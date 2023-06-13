<?php

namespace api\modules\cabinet\models;

use common\models\Country;

class UserProfile extends \common\models\UserProfile
{

    public function fields()
    {
        return [
            'firstname',
            'middlename',
            'lastname',
            'gender',
            'phone',
            'age' => function() {
                return strtotime($this->age);
            },
            'city',
            'full_address',
            'questionnaire' => function(){
                $checkPhone = $this->phone != null;
                $education = Education::find()->where(['user_id' => $this->user_id])->one();
                $experience = Experience::find()->where(['user_id' => $this->user_id])->one();
                if ($checkPhone && $education && $experience)
                    return true;
                else return false;
            },
            'country_id' => function(){
                $countriesArray = Country::find()->select(['title', 'id'])->indexBy('id')->column();
                $list = [];
                foreach ($countriesArray as $id => $name)
                    $list[] = [
                        'id' => $id,
                        'name' => \Yii::t('countries', $name, null, 'ru-RU')
                    ];
                return ['value' => $this->country_id, 'list' => $list];
            },
            'education' => function() {
                return Education::find()->where(['user_id' => $this->user_id])->all();
            },
            'experience' => function() {
                return Experience::find()->where(['user_id' => $this->user_id])->all();
            },
            'scores'
        ];
    }
}
