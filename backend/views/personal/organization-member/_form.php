<?php

use common\models\User;
use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OrganizationMember */
/* @var $form yii\bootstrap4\ActiveForm */

$organizationsData = \common\models\Organization::find()->all();
$usersData = \common\models\UserProfile::find()->where(['role' => \common\models\UserProfile::ROLE_ORGANIZATION_MEMBER])->all();
$organizations = [];
foreach ($organizationsData as $datum)
    $organizations[] = [
        'title' => $datum->title,
        'id' => $datum->id,
    ];
$users = [];
foreach ($usersData as $datum) {
    $organizationMember = \common\models\OrganizationMember::find()->where(['user_id' => $datum->user_id])->one();
    if (!$organizationMember)
        $users[] = [
            'name' => $datum->user->email . ' ' . $datum->lastname . ' ' . $datum->firstname,
            'id' => $datum->user_id,
        ];
}
?>

<div class="user-form">
    <?php $form = ActiveForm::begin() ?>
    <div class="card">
        <div class="card-body">

            <?php if ($model->isNewRecord) {
                echo $form->field($model, 'user_id')->dropDownList(\yii\helpers\ArrayHelper::map(
                    $users,
                    'id',
                    'name'
                ), ['prompt' => '']);
            }?>
            <?php echo $form->field($model, 'organization_id')->dropDownList(\yii\helpers\ArrayHelper::map(
                $organizations,
                'id',
                'title'
            ), ['prompt' => '']) ?>
            <?php echo $form->field($model, 'position')->textInput() ?>
            <?php echo $form->field($model, 'is_deleted')->checkbox() ?>
        </div>
        <div class="card-footer">
            <?php echo Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>
