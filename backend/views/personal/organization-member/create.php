<?php
/* @var $this yii\web\View */
/* @var $model \common\models\OrganizationMember */
$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Organization member',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Organization member'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <?php echo $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
