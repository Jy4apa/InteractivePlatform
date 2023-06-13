<?php

namespace api\modules\intern\models;

use common\models\User;
use Yii;

class Intern extends \common\models\Intern
{

    public function fields()
    {
        return [
            'id',
            'user' => function() {
                $user = User::findOne($this->user_id);
                return $user->userProfile->lastname . ' ' . $user->userProfile->firstname;
            }
        ];
    }
}
