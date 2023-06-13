<?php

namespace api\modules\cabinet\models;

class CandidateOrder extends \common\models\CandidateOrder
{

    public function fields()
    {
        return ['id',
            'status' => function() {
                return self::statuses()[$this->status];
            },
            'direction' => function() {
                return $this->direction ? $this->direction->id : null;
            }
        ];
    }
}
