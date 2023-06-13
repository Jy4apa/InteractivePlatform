<?php
/* @var $this yii\web\View */
/* @var $model \common\models\Mentor */
$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Mentor',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Mentor'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <?php echo $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
