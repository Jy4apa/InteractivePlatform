<?php

namespace api\modules\cabinet\models;

class Experience extends \common\models\Experience
{

    public function fields()
    {
        return ['id', 'income', 'name', 'post',
            'date_start' => function() {
                return strtotime($this->date_start) * 1000;
            },
            'date_end' => function() {
                return strtotime($this->date_end) * 1000;
            },
            'responsibilities',
            'key_skills' => function () {
                return unserialize($this->key_skills);
            }
        ];
    }
}
