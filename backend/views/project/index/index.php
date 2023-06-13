<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = Yii::t('backend', 'Project management');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="index-index">
    <?php if(Yii::$app->user->can('administrator') || Yii::$app->user->can('manager') ) : ?>
        <h4><a href="<?= Url::to('@backendUrl/project/course');?>"><?php echo Yii::t('backend', 'Internship courses'); ?></a></h4>
        <h4><a href="<?= Url::to('@backendUrl/project/stage-course');?>"><?php echo Yii::t('backend', 'Stage courses'); ?></a></h4>
    <?php endif; ?>

</div>
