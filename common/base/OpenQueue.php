<?php

namespace common\base;

class OpenQueue extends \yii\queue\redis\Queue
{
    public $path;
}
