<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = Yii::t('backend', 'Personal management');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="index-index">
    <?php if(Yii::$app->user->can('administrator') || Yii::$app->user->can('manager') ) : ?>
        <h4><a href="<?= Url::to('@backendUrl/personal/organization');?>"><?php echo Yii::t('backend', 'Organizations'); ?></a></h4>
        <h4><a href="<?= Url::to('@backendUrl/personal/organization-member');?>"><?php echo Yii::t('backend', 'Organization members'); ?></a></h4>
        <h4><a href="<?= Url::to('@backendUrl/personal/mentor');?>"><?php echo Yii::t('backend', 'Mentors'); ?></a></h4>
        <h4><a href="<?= Url::to('@backendUrl/personal/supervisor');?>"><?php echo Yii::t('backend', 'Supervisors'); ?></a></h4>
        <h4><a href="<?= Url::to('@backendUrl/personal/intern');?>"><?php echo Yii::t('backend', 'Interns'); ?></a></h4>
        <h4><a href="<?= Url::to('@backendUrl/personal/candidate');?>"><?php echo Yii::t('backend', 'Candidates'); ?></a></h4>
    <?php endif; ?>

</div>
