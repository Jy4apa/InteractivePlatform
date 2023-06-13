<?php
/* @var $this yii\web\View */
/* @var $model \common\models\Organization */
$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Organization',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Organization'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <?php echo $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
