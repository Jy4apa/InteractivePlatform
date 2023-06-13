<?php

namespace backend\controllers\statistics;

use backend\models\search\CandidateSearch;
use Yii;
use yii\web\Controller;

/**
 * Application timeline controller
 */
class CandidateController extends Controller
{
    public $layout = 'common';

    /**
     * Lists all TimelineEvent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CandidateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $transactionsData = $dataProvider
            ->query
            ->select('is_recommended, COUNT(*) AS cnt')
            ->groupBy('is_recommended')
            ->all();

        $candidateData = array_map(function($el) {
            return ['is_recommended' => $el->is_recommended == 1 ? 'Рекомендованные' : 'Нерекомендованные', 'cnt' => $el->cnt];
        }, $transactionsData);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'candidateData' => $candidateData
        ]);
    }
}
