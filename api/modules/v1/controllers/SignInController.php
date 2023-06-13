<?php

namespace api\modules\v1\controllers;

use api\controllers\SiteController;
use api\modules\v1\resources\User;
use common\commands\SendEmailCommand;
use common\models\UserToken;
use common\modules\user\models\LoginForm;
use common\modules\user\models\PasswordResetRequestForm;
use common\modules\user\models\ResendEmailForm;
use common\modules\user\models\ResetPasswordForm;
use common\modules\user\models\SignupForm;
use Yii;
use yii\authclient\AuthAction;
use yii\base\Exception;
use yii\base\InvalidArgumentException;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\rest\IndexAction;
use yii\rest\OptionsAction;
use yii\rest\CreateAction;
use yii\rest\ViewAction;
use yii\rest\UpdateAction;
use yii\rest\DeleteAction;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Class SignInController
 * @package frontend\modules\user\controllers
 * @author Eugene Terentev <eugene@terentev.net>
 */
class SignInController extends SiteController
{
    /**
     * @var string
     */
    public $modelClass = 'api\modules\v1\resources\User';

    /**
     * @SWG\Post(path="/v1/signup",
     *     tags={"signup", "auth"},
     *     summary="Retrieves the collection of Articles.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Article collection response",
     *         @SWG\Schema(ref = "#/definitions/User")
     *     ),
     * )
     **/

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    /**
     * @return array
     */
    public function actionLogin(): array
    {
        $model = new LoginForm();
        $response = ['success' => false];

        try {
            $model->attributes = Yii::$app->request->post();
            $token = $model->login();
            if($token) {
                $user = $model->getUser();
                if($user->status != \common\models\User::STATUS_ACTIVE) {
                    return [
                        'success' => false,
                        'error' => 'User not active'
                    ];
                }
                return [
                    'success' => true,
                    'token' => $token
                ];
            }
            else
            {
                Yii::$app->response->setStatusCode(422);
                $modelErrors = $model->getErrors();
                foreach ($modelErrors as $fieldError => $errors)
                {
                    $response['error'] = $errors[0];
                    break;
                }

                return $response;
            }
        }
        catch (\Exception $e)
        {
            Yii::$app->response->setStatusCode(500);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function actionSignup(): array
    {
        $model = new SignupForm();
        $params = Yii::$app->request->post();
        $model->attributes = $params;
        $username = stristr($model->email, '@', true);
        $users = User::find()->where(['like', 'username', $username])->count();
        if ($users != 0)
        {
            $lastUser = User::find()->orderBy('id DESC')->limit(1)->one();
            $username = $username . $lastUser->id;
        }
        $model->username = $username;
        $response = ['success' => false];

        try {
            $statusRegister = $model->signup();

            if ($statusRegister)
                return ['success' => true];

            else
            {
                Yii::$app->response->setStatusCode(422);
                $modelErrors = $model->getErrors();
                foreach ($modelErrors as $fieldError => $errors)
                {
                    $response['error'] = $errors[0];
                    break;
                }

                return $response;
            }
        }
        catch (\Exception $exception)
        {
            Yii::$app->response->setStatusCode(500);
            return ['success' => false, 'error' => $exception->getMessage()];
        }
    }

    /**
     * @param $token
     * @return Response
     * @throws BadRequestHttpException
     */
    public function actionActivation($token)
    {
        $token = UserToken::find()
            ->byType(UserToken::TYPE_ACTIVATION)
            ->byToken($token)
            ->notExpired()
            ->one();

        if (!$token) {
            throw new BadRequestHttpException;
        }

        $user = $token->user;
        $user->updateAttributes([
            'status' => User::STATUS_ACTIVE
        ]);
        $token->delete();
        Yii::$app->getUser()->login($user);
        Yii::$app->getSession()->setFlash('alert', [
            'body' => Yii::t('frontend', 'Your account has been successfully activated.'),
            'options' => ['class' => 'alert-success']
        ]);

        return $this->goHome();
    }

    /**
     * @return string|Response
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('alert', [
                    'body' => Yii::t('frontend', 'Check your email for further instructions.'),
                    'options' => ['class' => 'alert-success']
                ]);

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('alert', [
                    'body' => Yii::t('frontend', 'Sorry, we are unable to reset password for email provided.'),
                    'options' => ['class' => 'alert-danger']
                ]);
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * @param $token
     * @return string|Response
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('alert', [
                'body' => Yii::t('frontend', 'New password was saved.'),
                'options' => ['class' => 'alert-success']
            ]);
            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionResendEmail()
    {
        $model = new ResendEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('alert', [
                    'body' => Yii::t('frontend', 'Check your email for further instructions.'),
                    'options' => ['class' => 'alert-success']
                ]);

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('alert', [
                    'body' => Yii::t('frontend', 'Sorry, we are unable to resend activation link for email provided.'),
                    'options' => ['class' => 'alert-danger']
                ]);
            }
        }

        return $this->render('resend-email', [
            'model' => $model,
        ]);
    }

    /**
     * @param $client \yii\authclient\BaseClient
     * @return bool
     * @throws Exception
     */
    public function successOAuthCallback($client)
    {
        // use BaseClient::normalizeUserAttributeMap to provide consistency for user attribute`s names
        $attributes = $client->getUserAttributes();
        $user = User::find()->where([
            'oauth_client' => $client->getName(),
            'oauth_client_user_id' => ArrayHelper::getValue($attributes, 'id')
        ])->one();
        if (!$user) {
            $user = new User();
            $user->scenario = 'oauth_create';
            $user->username = ArrayHelper::getValue($attributes, 'login');
            // check default location of email, if not found as in google plus dig inside the array of emails
            $email = ArrayHelper::getValue($attributes, 'email');
            if($email === null){
                $email = ArrayHelper::getValue($attributes, ['emails', 0, 'value']);
            }
            $user->email = $email;
            $user->oauth_client = $client->getName();
            $user->oauth_client_user_id = ArrayHelper::getValue($attributes, 'id');
            $user->status = User::STATUS_ACTIVE;
            $password = Yii::$app->security->generateRandomString(8);
            $user->setPassword($password);
            if ($user->save()) {
                $profileData = [];
                if ($client->getName() === 'facebook') {
                    $profileData['firstname'] = ArrayHelper::getValue($attributes, 'first_name');
                    $profileData['lastname'] = ArrayHelper::getValue($attributes, 'last_name');
                }
                $user->afterSignup($profileData);
                $sentSuccess = Yii::$app->commandBus->handle(new SendEmailCommand([
                    'view' => 'oauth_welcome',
                    'params' => ['user' => $user, 'password' => $password],
                    'subject' => Yii::t('frontend', '{app-name} | Your login information', ['app-name' => Yii::$app->name]),
                    'to' => $user->email
                ]));
                if ($sentSuccess) {
                    Yii::$app->session->setFlash(
                        'alert',
                        [
                            'options' => ['class' => 'alert-success'],
                            'body' => Yii::t('frontend', 'Welcome to {app-name}. Email with your login information was sent to your email.', [
                                'app-name' => Yii::$app->name
                            ])
                        ]
                    );
                }

            } else {
                // We already have a user with this email. Do what you want in such case
                if ($user->email && User::find()->where(['email' => $user->email])->count()) {
                    Yii::$app->session->setFlash(
                        'alert',
                        [
                            'options' => ['class' => 'alert-danger'],
                            'body' => Yii::t('frontend', 'We already have a user with email {email}', [
                                'email' => $user->email
                            ])
                        ]
                    );
                } else {
                    Yii::$app->session->setFlash(
                        'alert',
                        [
                            'options' => ['class' => 'alert-danger'],
                            'body' => Yii::t('frontend', 'Error while oauth process.')
                        ]
                    );
                }

            };
        }
        if (Yii::$app->user->login($user, 3600 * 24 * 30)) {
            return true;
        }

        throw new Exception('OAuth error');
    }
}