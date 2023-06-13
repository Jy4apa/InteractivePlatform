<?php

namespace api\modules\supervisor\models;

use api\modules\cabinet\models\CandidateOrder;
use api\modules\v1\resources\User;
use common\models\Course;

class Candidate extends \common\models\Candidate
{

    public function fields()
    {
        $user = User::findOne($this->user_id);
        return [
            'candidate_id' => function() {
                return $this->id;
            },
            'firstname' => function() use($user){
                return $user->userProfile->firstname;
            },
            'lastname' => function() use($user){
                return $user->userProfile->lastname;
            },
            'email' => function() use($user){
                return $user->email;
            },
            'order_status',
            'testing_status' => function() {
                return self::testingStatuses()[$this->testing_status];
            },
            'order' => function() {
                $course = Course::getLast();
                return CandidateOrder::find()->where(['candidate_id' => $this->id, 'course_id' => $course->id])->one();
            },
            'scores' => function(){
                return $this->user->userProfile->scores;
            },
            'is_recommended' => function(){
                return $this->is_recommended;
            }
        ];
    }
}
