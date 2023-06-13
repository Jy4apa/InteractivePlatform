<?php

namespace api\modules\intern\controllers;

use api\controllers\BaseController;
use api\modules\intern\models\Intern;
use common\models\InternOrder;
use common\models\UserProfile;
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

    public function actionReply(): array
    {
        try {
            $vacancy_id = Yii::$app->request->post('vacancy_id');
            if (!$vacancy_id)
            {
                Yii::$app->response->setStatusCode(422);
                return ['success' => false, 'error' => 'Неизвестный идентификатор вакансии'];
            }
            $user = Yii::$app->user->identity;
            if ($user->userProfile->role != UserProfile::ROLE_INTERN)
            {
                Yii::$app->response->setStatusCode(403);
                return ['success' => false, 'error' => 'Вам не разрешено выполнять данное действие'];
            }
            $intern = Intern::find()->where(['user_id' => $user->id])->limit(1)->one();
            if ($intern)
            {
                $internOrder = InternOrder::find()->where(['intern_id' => $intern->id, 'vacancy_id' => $vacancy_id])->one();
                if ($internOrder)
                    return ['success' => false, 'error' => 'Вы уже оставляли отклик на эту вакансию'];
                else {
                    $internOrder = new InternOrder();
                    $internOrder->intern_id = $intern->id;
                    $internOrder->vacancy_id = $vacancy_id;
                    $internOrder->status = InternOrder::STATUS_PENDING;
                    $internOrder->evaluate = 0;
                    $internOrder->save();
                    return ['success' => true];
                }
            }
            return ['success' => false, 'error' => 'Не удалось получить информацию о стажере'];
        }
        catch (\Exception $exception)
        {
            Yii::$app->response->setStatusCode(500);
            return ['success' => false, 'error' => 'Не удалось оставить отклик на вакансию'];
        }
    }
}