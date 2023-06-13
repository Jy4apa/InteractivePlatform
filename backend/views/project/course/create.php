<?php
/* @var $this yii\web\View */
/* @var $model backend\models\UserForm */
$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Course',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Internship courses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <?php echo $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
