<?php

use common\grid\EnumColumn;
use common\models\Course;
use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var backend\models\search\CourseSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */
$this->title = Yii::t('backend', 'Internship course');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card">
    <div class="card-header">
        <?php echo Html::a(Yii::t('backend', 'Add New {modelClass}', [
            'modelClass' => 'Course',
        ]), ['create'], ['class' => 'btn btn-success']) ?>
    </div>

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
                'title',
                [
                    'attribute' => 'date_start',
                    'value' => function ($model) {
                        return date('d.m.Y H:i:s', strtotime($model->date_start));
                    }
                ],
                [
                    'attribute' => 'date_end',
                    'value' => function ($model) {
                        return date('d.m.Y H:i:s', strtotime($model->date_end));
                    }
                ],
                [
                    'class' => EnumColumn::class,
                    'attribute' => 'status',
                    'enum' => Course::statuses(),
                    'filter' => Course::statuses()
                ],

                [
                    'class' => \common\widgets\ActionColumn::class,
                    'template' => '{view} {update} {delete}',
                    'options' => ['style' => 'width: 140px'],

                ],
            ],
        ]); ?>
    </div>

    <div class="card-footer">
        <?php echo getDataProviderSummary($dataProvider) ?>
    </div>
</div>
