<?php

namespace api\modules\member\models;

use api\modules\cabinet\models\InternshipDirection;
use api\modules\intern\models\Intern;
use common\models\InternOrder;
use Yii;

class Vacancy extends \common\models\Vacancy
{

    public function fields()
    {
        $user = Yii::$app->user->identity;
        return [
            'id',
            'direction' => function(){
                $directions = InternshipDirection::find()->select('title')->indexBy('id')->column();

                $directions = array_map(function($direction) {
                    return Yii::t('directions', $direction);
                }, $directions);
                return ['direction_id' => $this->direction_id, 'list' => $directions];
            },
            'intern_id',
            'mentor_id' => function(){
                return [
                    'value' => $this->mentor_id,
                    'list' => Mentor::getFreeMentors($this->organization_id)
                ];
            },
            'organization' => function(){
                return $this->organization->title;
            },
            'reply' => function() use ($user){
                $intern = Intern::find()->where(['user_id' => $user->id])->limit(1)->one();
                if (!$intern)
                    return null;
                $order = InternOrder::find()->where(['intern_id' => $intern->id, 'vacancy_id' => $this->id])->limit(1)->one();
                return $order?->status;
            },
            'income',
            'title',
            'address',
            'geo_lat',
            'geo_lon',
            'description',
            'schedule',
            'status',
            'is_publish'
        ];
    }
}
