<?php

namespace api\modules\mentor\models;

use common\models\User;
use Yii;

class Mentor extends \common\models\Mentor
{

    public function fields()
    {
        return [
            'id',
            'rating',
            'user' => function() {
                $user = User::findOne($this->user_id);
                return $user->userProfile->lastname . ' ' . $user->userProfile->firstname;
            },
            'organization' => function() {
                return $this->organization;
            }
        ];
    }
}
