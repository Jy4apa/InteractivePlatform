<?php

namespace api\modules\mentor\controllers;

use api\controllers\BaseController;
use api\modules\cabinet\models\UserProfile;
use api\modules\mentor\models\InternOrder;
use api\modules\member\models\Vacancy;
use api\modules\mentor\models\Mentor;
use Yii;
use yii\rest\OptionsAction;
use yii\web\Response;

class UserController extends BaseController
{

    public function init()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'options' => [
                'class' => OptionsAction::class,
                'collectionOptions' => ['GET', 'POST', 'HEAD', 'OPTIONS'],
                'resourceOptions' => ['GET', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
            ]
        ];
    }

    public function actionGetMentor(): array
    {
        try {
            $user = Yii::$app->user->identity;
            if ($user->userProfile->role != UserProfile::ROLE_MENTOR)
            {
                Yii::$app->response->setStatusCode(403);
                return ['success' => false, 'error' => 'Вам не разрешено выполнять данное действие'];
            }
            $mentor = Mentor::find()->where(['user_id' => $user->id])->limit(1)->one();
            if (!$mentor)
                return ['success' => false, 'error' => 'Не удалось получить информацию о наставнике'];
            return ['success' => true, 'data' => $mentor];
        } catch (\Exception $exception) {
            Yii::$app->response->setStatusCode(500);
            return ['success' => false, 'error' => 'Внутренняя ошибка сервера'];
        }
    }

    public function actionListReplies()
    {
//        try {
            $user = Yii::$app->user->identity;
            if ($user->userProfile->role != UserProfile::ROLE_MENTOR)
            {
                Yii::$app->response->setStatusCode(403);
                return ['success' => false, 'error' => 'Вам не разрешено выполнять данное действие'];
            }
            $mentor = Mentor::find()->where(['user_id' => $user->id])->limit(1)->one();
            $vacancy = Vacancy::find()->where(['mentor_id' => $mentor->id])->one();
            if ($vacancy)
            {
                $replies = InternOrder::find()->where(['vacancy_id' => $vacancy->id])->all();
                return ['success' => true, 'data' => $replies];
            }
            return ['success' => false, 'error' => 'Не удалось получить информацию о вакансии'];
//        }
//        catch (\Exception $exception) {
//            Yii::$app->response->setStatusCode(500);
//            return ['success' => false, 'error' => 'Внутренняя ошибка сервера'];
//        }
    }
}