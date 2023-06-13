<?php

use common\grid\EnumColumn;
use common\models\Candidate;
use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var backend\models\search\CandidateSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */
$this->title = Yii::t('backend', 'Candidate');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card">

    <div class="card-body p-0">
        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{pager}",
            'options' => [
                'class' => ['gridview', 'table-responsive'],
            ],
            'tableOptions' => [
                'class' => ['table', 'text-nowrap', 'table-striped', 'table-bordered', 'mb-0'],
            ],
            'columns' => [
                [
                    'attribute' => 'id',
                    'options' => ['style' => 'width: 5%'],
                ],
                [
                    'attribute' => 'user_id',
                    'value' => function ($model) {
                        return $model->user->userProfile->lastname . ' ' . $model->user->userProfile->firstname . ' (' . $model->user->email . ')';
                    }
                ],
                [
                    'attribute' => 'age',
                    'value' => function ($model) {
                        return $model->user->userProfile->age . ' (' . date('Y', time()) - date('Y', strtotime($model->user->userProfile->age)) . ')';
                    }
                ],
                [
                    'attribute' => 'city',
                    'value' => function ($model) {
                        return $model->user->userProfile->city;
                    }
                ],
                [
                    'attribute' => 'scores',
                    'value' => function ($model) {
                        return $model->user->userProfile->scores;
                    }
                ],

                [
                    'class' => \common\widgets\ActionColumn::class,
                    'template' => '{view} {update}',
                    'options' => ['style' => 'width: 90px'],

                ],
            ],
        ]); ?>
    </div>

    <div class="card-footer">
        <?php echo getDataProviderSummary($dataProvider) ?>
    </div>
</div>
