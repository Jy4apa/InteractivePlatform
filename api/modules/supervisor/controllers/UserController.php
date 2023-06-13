<?php

namespace api\modules\supervisor\controllers;

use api\controllers\BaseController;
use api\modules\member\models\Vacancy;
use api\modules\supervisor\models\Candidate;
use api\modules\cabinet\models\CandidateOrder;
use api\modules\cabinet\models\UserProfile;
use common\models\Course;
use common\models\OrganizationMember;
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

    public function actionApproveVacancy($id): array
    {
        try {
            $user = Yii::$app->user->identity;
            if ($user->userProfile->role != UserProfile::ROLE_SUPERVISOR)
            {
                Yii::$app->response->setStatusCode(403);
                return ['success' => false, 'error' => 'Вам не разрешено выполнять данное действие'];
            }
            $vacancy = Vacancy::findOne($id);
            if ($vacancy)
            {
                $vacancy->status = Vacancy::STATUS_SUCCESS;
                $vacancy->is_publish = 1;
                $vacancy->save();
                return ['success' => true];
            }
            else return ['success' => false, 'error' => 'Вакансия с таким идентификатором не найдена'];
        }
        catch (\Exception $exception)
        {
            Yii::$app->response->setStatusCode(500);
            return ['success' => false, 'Произошла ошибка сервера. Не удалось подтвердить вакансию'];
        }
    }

    public function actionCancelVacancy($id): array
    {
        try {
            $user = Yii::$app->user->identity;
            if ($user->userProfile->role != UserProfile::ROLE_SUPERVISOR)
            {
                Yii::$app->response->setStatusCode(403);
                return ['success' => false, 'error' => 'Вам не разрешено выполнять данное действие'];
            }
            $vacancy = Vacancy::findOne($id);
            if ($vacancy)
            {
                $vacancy->status = Vacancy::STATUS_CANCEL;
                $vacancy->is_publish = 0;
                $vacancy->save();
                return ['success' => true];
            }
            else return ['success' => false, 'error' => 'Вакансия с таким идентификатором не найдена'];
        }
        catch (\Exception $exception)
        {
            Yii::$app->response->setStatusCode(500);
            return ['success' => false, 'Произошла ошибка сервера. Не удалось подтвердить вакансию'];
        }
    }

    public function actionEditVacancy($id): array
    {
        try {
            $user = Yii::$app->user->identity;
            $vacancy = Vacancy::findOne($id);
            if ($user->userProfile->role != UserProfile::ROLE_SUPERVISOR) {
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

    public function actionListCandidate(): array
    {
        $currentCourse = Course::getActiveCourse();
        $candidates = Candidate::find()
            ->leftJoin('candidate_order', 'candidate.id = candidate_order.candidate_id')
            ->leftJoin('user_profile', 'candidate.user_id = user_profile.user_id')
            ->where(['candidate_order.course_id' => $currentCourse->id])
            ->groupBy('id')
            ->all();

        return ['success' => true, 'data' => $candidates];
    }

    public function actionGetCandidate(): array
    {
        try {
            $user = Yii::$app->user->identity;
            $candidate = Candidate::find()->where(['user_id' => $user->id])->limit(1)->one();
            return ['success' => true, 'data' => $candidate];
        }
        catch (\Exception $exception)
        {
            Yii::$app->response->setStatusCode(500);
            return ['success' => false, 'error' => 'Произошла ошибка при обработке данных, попробуйте ещё раз'];
        }
    }

    public function actionCreateOrder(): array
    {
        try {
            $direction = Yii::$app->request->post('direction');
            $user = Yii::$app->user->identity;

            $candidate = Candidate::find()->where(['user_id' => $user->id])->limit(1)->one();
            if (!$candidate)
            {
                $candidate = new Candidate();
                $candidate->user_id = $user->id;
                $candidate->save();
            }
            $course = Course::getActiveCourse();
            if (!$course)
                return ['success' => false, 'error' => 'Прием заявок завершен'];

            $candidateOrder = CandidateOrder::find()->where([
                'candidate_id' => $candidate->id,
                'course_id' => $course->id
            ])->limit(1)->one();

            if ($candidateOrder)
                return ['success' => false, 'error' => 'Вы не можете подать ещё одну заявку на текущем потоке'];
            else
            {
                $candidateOrder = new CandidateOrder();
                $candidateOrder->direction_id = $direction;
                $candidateOrder->candidate_id = $candidate->id;
                $candidateOrder->course_id = $course->id;
                if ($candidateOrder->validate() && $candidateOrder->save())
                    return ['success' => true];
                else
                {
                    Yii::$app->response->setStatusCode(422);
                    return ['success' => false, 'error' => $candidateOrder->getErrors()[0]];
                }
            }
        }
        catch (\Exception $exception)
        {
            Yii::$app->response->setStatusCode(500);
            return ['success' => false, 'error' => 'Произошла ошибка при подаче заявки, попробуйте ещё раз'];
        }
    }

    public function actionGetCandidateOrder(): array
    {
        try {
            $user = Yii::$app->user->identity;
            $candidate = Candidate::find()->where(['user_id' => $user->id])->limit(1)->one();
            $course = Course::getLast();
            $candidateOrder = CandidateOrder::find()->where(['candidate_id' => $candidate->id, 'course_id' => $course->id])->one();
            return ['success' => true, 'data' => $candidateOrder];
        }
        catch (\Exception $exception)
        {
            Yii::$app->response->setStatusCode(500);
            return ['success' => false, 'error' => 'Не удалось получить данные по заявке, либо заявка не найдена'];
        }
    }

    public function actionUpdateDirection($id): array
    {
        try {
            $direction = Yii::$app->request->post('direction');
            $candidateOrder = CandidateOrder::findOne($id);
            $user = Yii::$app->user->identity;
            if ($user->id === $candidateOrder->candidate->user->id)
            {
                $candidateOrder->direction_id = $direction;
                if ($candidateOrder->validate() && $candidateOrder->save())
                    return ['success' => true];
                else return ['success' => false, 'error' => $candidateOrder->getErrors()[0]];
            }
            else
            {
                Yii::$app->response->setStatusCode(403);
                return ['success' => false, 'error' => 'В доступе отказано'];
            }
        }
        catch (\Exception $exception)
        {
            Yii::$app->response->setStatusCode(500);
            return ['success' => false, 'error' => 'Произошла ошибка, попробуйте ещё раз'];
        }
    }
}