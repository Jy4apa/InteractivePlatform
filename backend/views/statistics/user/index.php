<?php

use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .apexcharts-container .apexcharts-legend.center.position-left {
        padding: 0px !important;
        left: -5px !important;
        top: -20px !important;
        margin-top: 20px !important;
    }
</style>

<div class="user-group">

    <?php

    $data = ArrayHelper::map($usersData, 'city', 'cnt');
    $labels = [];
    array_walk($data, function($item, $key) use(&$labels) {
        $labels[] = "$key: $item";
    });

    echo \onmotion\apexcharts\ApexchartsWidget::widget([
        'type' => 'pie', // default area
        'height' => '600', // default 350
        'chartOptions' => [
            'chart' => [
                'toolbar' => [
                    'show' => true,
                    'autoSelected' => 'zoom'
                ],
            ],
            'labels' => $labels,
            'plotOptions' => [
                'bar' => [
                    'horizontal' => false,
                ],
            ],
            'fill' => [
                'type' => 'solid',
                'fillOpacity' => 0.7
            ],
            'legend' => [
                'position' => 'left',
                'width' => '300',
            ],
        ],
        'series' => array_values($data)
    ]); ?>
</div>

<div class="group">
    <hr>
    <?php echo Yii::t('backend', 'Total'); ?>: <b><?= array_sum($data); ?> <?php echo Yii::t('backend', 'users'); ?></b>
</div>
