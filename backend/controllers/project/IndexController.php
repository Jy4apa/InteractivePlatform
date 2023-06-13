<?php

namespace backend\controllers\project;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

class IndexController extends Controller
{

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}
