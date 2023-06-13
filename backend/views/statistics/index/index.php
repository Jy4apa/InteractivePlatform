<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = Yii::t('backend', 'Statistics');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="index-index">
    <?php if(Yii::$app->user->can('administrator') || Yii::$app->user->can('manager') ) : ?>
        <h4><a href="<?= Url::to('@backendUrl/statistics/user');?>"><?php echo Yii::t('backend', 'Users'); ?></a></h4>
        <h4><a href="<?= Url::to('@backendUrl/statistics/candidate');?>"><?php echo Yii::t('backend', 'Recommended candidates'); ?></a></h4>
    <?php endif; ?>

</div>
