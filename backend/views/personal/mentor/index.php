<?php

use common\grid\EnumColumn;
use common\models\Mentor;
use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var backend\models\search\MentorSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */
$this->title = Yii::t('backend', 'Mentor');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card">
    <div class="card-header">
        <?php echo Html::a(Yii::t('backend', 'Add New {modelClass}', [
            'modelClass' => 'Mentor',
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
                [
                    'attribute' => 'user_id',
                    'value' => function ($model){
                        return $model->user->userProfile->lastname . ' ' . $model->user->userProfile->firstname . ' (' . $model->user->email . ')';
                    }
                ],
                [
                    'attribute' => 'organization_id',
                    'value' => function($model) {
                        return $model->organization->title;
                    }
                ],
                [
                    'attribute' => 'organization_member_id',
                    'value' => function($model){
                        $member = \common\models\User::findOne($model->organization_member_id);
                        return $member->userProfile->lastname . ' ' . $member->userProfile->firstname . ' (' . $member->email . ')';
                    }
                ],
                [
                    'attribute' => 'rating',
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
