<?php
/* @var $this yii\web\View */
/* @var $model \common\models\Supervisor */
$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Supervisor',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Supervisor'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <?php echo $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
