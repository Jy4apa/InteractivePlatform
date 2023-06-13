<?php

namespace api\modules\mentor\models;

use common\models\Intern;
use common\models\User;
use Yii;

class InternOrder extends \common\models\InternOrder
{

    public function fields()
    {
        return [
            'id',
            'status',
            'user' => function() {
                $intern = Intern::findOne($this->intern_id);
                $user = User::findOne($intern->user_id);
                return [
                    'name' => $user->userProfile->lastname . ' ' . $user->userProfile->firstname,
                    'info' => $user->userProfile
                ];
            },
        ];
    }
}
