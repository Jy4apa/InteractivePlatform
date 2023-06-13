<?php

/* @var $this yii\web\View */
/* @var $model common\models\Supervisor */

$this->title = Yii::t('backend', 'Update {modelClass}: ', ['modelClass' => 'Supervisor']);
$this->params['breadcrumbs'][] = ['label'=>Yii::t('backend', 'Update')];
?>
<div class="user-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
