<?php

namespace api\modules\member\models;

use common\models\User;
use Yii;

class Mentor extends \common\models\Mentor
{

    public static function getFreeMentors($organization_id)
    {
        $mentors = self::find()->where(['organization_id' => $organization_id])->all();
        $data = [];
        foreach ($mentors as $mentor)
        {
            if (empty($mentor->vacancy))
                $data[] = $mentor;
        }
        return $data;
    }

    public function fields()
    {
        return [
            'id',
            'rating',
            'user' => function() {
                $user = User::findOne($this->user_id);
                return $user->userProfile->lastname . ' ' . $user->userProfile->firstname;
            }
        ];
    }
}
