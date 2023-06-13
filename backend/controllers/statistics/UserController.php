<?php

namespace backend\controllers\statistics;

use backend\models\search\UserSearch;
use Yii;
use yii\web\Controller;

/**
 * Application timeline controller
 */
class UserController extends Controller
{
    public $layout = 'common';

    /**
     * Lists all TimelineEvent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $usersData = $dataProvider
            ->query
            ->joinWith('userProfile')
            ->select('city, COUNT(*) AS cnt')
            ->groupBy('city')
            ->asArray()
            ->createCommand()
            ->queryAll();

        $usersData = array_map(function($el) {
            if ($el['city'] == null)
                $el['city'] = 'Не задан';
            return ['city' => $el['city'], 'cnt' => $el['cnt'] + 0];
        }, $usersData);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'usersData' => $usersData
        ]);
    }
}
