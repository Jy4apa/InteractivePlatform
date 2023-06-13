<?php

namespace api\modules\cabinet\controllers;

use api\controllers\BaseController;
use api\modules\cabinet\models\Candidate;
use api\modules\cabinet\models\CandidateOrder;
use common\models\Course;
use common\models\StageCourse;
use common\models\UserProfile;
use Yii;
use yii\rest\OptionsAction;
use yii\web\Response;

class CandidateController extends BaseController
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
            $courseStage = StageCourse::find()->where(['course_id' => $course->id, 'title' => StageCourse::STAGE_START])->one();
            if (time() > strtotime($courseStage->date_end))
                return ['success' => false, 'error' => 'Этап приема заявок завершен'];

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
                {
                    $recommended = UserProfile::checkCandidateRecommended($user->id);
                    if ($recommended === true)
                    {
                        $candidate->order_status = Candidate::ORDER_STATUS_CAREER_SCHOOL;
                        $candidate->save();
                        $candidateOrder->status = CandidateOrder::STATUS_SUCCESS;
                        $candidateOrder->save();
                        return ['success' => true];
                    }
                    else {
                        $candidateOrder->status = CandidateOrder::STATUS_CANCEL;
                        $candidateOrder->save();
                        return ['success' => false, 'error' => 'Ваша заявка не прошла по критериям отбора: ' . $recommended];
                    }
                }
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