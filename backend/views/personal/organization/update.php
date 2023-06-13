<?php

/* @var $this yii\web\View */
/* @var $model common\models\Organization */

$this->title = Yii::t('backend', 'Update {modelClass}: ', ['modelClass' => 'Organization']);
$this->params['breadcrumbs'][] = ['label'=>Yii::t('backend', 'Update')];
?>
<div class="user-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
