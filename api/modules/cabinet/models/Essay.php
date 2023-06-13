<?php

namespace api\modules\cabinet\models;

class Essay extends \common\models\Essay
{

    public function fields()
    {
        return ['id', 'topic', 'text'];
    }
}
