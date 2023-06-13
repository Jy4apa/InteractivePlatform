<?php

/* @var $this yii\web\View */
/* @var $model common\models\Course */

$this->title = Yii::t('backend', 'Update {modelClass}: ', ['modelClass' => 'Course']);
$this->params['breadcrumbs'][] = ['label'=>Yii::t('backend', 'Update')];
?>
<div class="user-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
