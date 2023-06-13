<?php

namespace api\modules\member\controllers;

use api\controllers\BaseController;
use api\modules\member\models\Mentor;
use api\modules\member\models\Vacancy;
use api\modules\supervisor\models\Candidate;
use api\modules\cabinet\models\UserProfile;
use common\models\Course;
use common\models\OrganizationMember;
use Yii;
use yii\rest\OptionsAction;
use yii\web\ForbiddenHttpException;
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

    public function actionGetVacancy($id): array
    {
        try {
            $vacancy = Vacancy::findOne($id);
            if ($vacancy)
                return ['success' => true, 'data' => $vacancy];
            else {
                Yii::$app->response->setStatusCode(400);
                return ['success' => false, 'error' => 'Неверный идентификатор вакансии'];
            }
        }
        catch (\Exception $exception)
        {
            Yii::$app->response->setStatusCode(500);
            return ['success' => true, 'error' => 'Ошибка сервера. Не удалось получить информацию о вакансии'];
        }
    }

    public function actionCreateVacancy(): array
    {
        try {
            $user = Yii::$app->user->identity;
            $vacancy = new Vacancy();
            $vacancy->load(Yii::$app->request->post(), '');
            $organizationMember = OrganizationMember::find()->where(['user_id' => $user->id])->one();
            $vacancy->organization_id = $organizationMember->organization->id;
            $vacancy->status = Vacancy::STATUS_PENDING;
            if ($vacancy->validate())
            {
                $vacancy->save();
                return ['success' => true];
            }
             else {
                $response = ['success' => false];
                Yii::$app->response->setStatusCode(422);
                $modelErrors = $vacancy->getErrors();
                foreach ($modelErrors as $fieldError => $errors) {
                    $response['error'] = $errors[0];
                    break;
                }
                return $response;
            }
        } catch (\Exception $exception) {
            Yii::$app->response->setStatusCode(500);
            return ['success' => true, 'error' => 'Ошибка сервера. Не удалось создать вакансию'];
        }
    }

    public function actionUpdateVacancy($id): array
    {
        try {
            $user = Yii::$app->user->identity;
            $organizationMember = OrganizationMember::find()->where(['user_id' => $user->id])->one();
            $vacancy = Vacancy::findOne($id);
            if ($organizationMember->organization_id != $vacancy->organization_id) {
                Yii::$app->response->setStatusCode(403);
                return ['success' => false, 'error' => 'Вам не разрешено выполнять данное действие'];
            } else {
                if ($vacancy->load(Yii::$app->request->post(), '') && $vacancy->validate()) {
                    $vacancy->save();
                    return ['success' => true];
                } else {
                    $response = ['success' => false];
                    Yii::$app->response->setStatusCode(422);
                    $modelErrors = $vacancy->getErrors();
                    foreach ($modelErrors as $fieldError => $errors) {
                        $response['error'] = $errors[0];
                        break;
                    }
                    return $response;
                }
            }
        } catch (\Exception $exception) {
            Yii::$app->response->setStatusCode(500);
            return ['success' => false, 'error' => 'Ошибка сервера. Не удалось редактировать вакансию'];
        }
    }

    public function actionListMentors(): array
    {
        try {
            $user = Yii::$app->user->identity;
            $organizationMember = OrganizationMember::find()->where(['user_id' => $user->id])->one();
            if ($organizationMember)
                return ['success' => true, 'data' => Mentor::getFreeMentors($organizationMember->organization_id)];
            else {
                Yii::$app->response->setStatusCode(403);
                return ['success' => false, 'error' => 'Вам не разрешено выполнять данное действие'];
            }
        }
        catch (\Exception $exception) {
            Yii::$app->response->setStatusCode(500);
            return ['success' => false, 'error' => 'Ошибка сервера. Не удалось получить список наставников'];
        }
    }

    public function actionListVacancyOrganization(): array
    {
        try {
            $user = Yii::$app->user->identity;
            if ($user->userProfile->role != UserProfile::ROLE_ORGANIZATION_MEMBER)
            {
                Yii::$app->response->setStatusCode(403);
                return ['success' => false, 'error' => 'Вам не разрешено выполнять данное действие'];
            }
            $organizationMember = OrganizationMember::find()->where(['user_id' => $user->id])->one();
            $vacancies = Vacancy::find()->where([
                'organization_id' => $organizationMember->organization_id,
                'is_deleted' => 0
            ])->all();
            return ['success' => true, 'data' => $vacancies];

        } catch (\Exception $exception) {
            Yii::$app->response->setStatusCode(500);
            return ['success' => false, 'error' => 'Ошибка сервера. Не удалось получить список вакансий'];
        }
    }
}