<?php

namespace api\modules\cabinet\models;

use common\models\Course;

class Candidate extends \common\models\Candidate
{

    public function fields()
    {
        return ['id',
            'order_status',
            'testing_status' => function() {
                return self::testingStatuses()[$this->testing_status];
            },
            'order' => function() {
                $course = Course::getLast();
                return CandidateOrder::find()->where(['candidate_id' => $this->id, 'course_id' => $course->id])->one();
            }
        ];
    }
}
