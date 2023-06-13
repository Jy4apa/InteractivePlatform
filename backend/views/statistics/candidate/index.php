<?php

use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Recommended candidates');
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

<div class="list">

    <?php

    $data = ArrayHelper::map($candidateData, 'is_recommended', 'cnt');

    $series = [
        [
            'name' => Yii::t('backend', 'Total'),
            'data' => array_values($data),
        ],
    ];

    echo \onmotion\apexcharts\ApexchartsWidget::widget([
        'type' => 'bar', // default area
        'height' => '600', // default 350
        'chartOptions' => [
            'chart' => [
                'toolbar' => [
                    'show' => true,
                    'autoSelected' => 'zoom'
                ],
            ],
            'xaxis' => [
                'labels' => [
                    'rotate' => -45
                ],
                'categories' => array_keys($data),
            ],
            'plotOptions' => [
                'bar' => [
                    'horizontal' => false,
                ],
            ],
            'dataLabels' => [
                'enabled' => false
            ],
            'stroke' => [
                'curve' => 'smooth',
                'colors' => ['transparent']
            ],
            'fill' => [
                'type' => 'solid',
                'fillOpacity' => 0.7
            ],
            'legend' => [
                'verticalAlign' => 'bottom',
                'horizontalAlign' => 'left',
            ],
        ],
        'series' => $series
    ]); ?>
</div>

<div class="group">
    <hr>
    <?php echo Yii::t('backend', 'Total'); ?>: <b><?= array_sum($data); ?> <?php echo Yii::t('backend', 'candidates'); ?></b>
</div>
