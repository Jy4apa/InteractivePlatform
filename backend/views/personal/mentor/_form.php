<?php

use common\models\User;
use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \common\models\Mentor */
/* @var $form yii\bootstrap4\ActiveForm */

$organizationsData = \common\models\Organization::find()->all();
$usersData = \common\models\UserProfile::find()->where(['role' => \common\models\UserProfile::ROLE_MENTOR])->all();
$membersData = \common\models\UserProfile::find()->where(['role' => \common\models\UserProfile::ROLE_ORGANIZATION_MEMBER])->all();
$organizations = [];
foreach ($organizationsData as $datum)
    $organizations[] = [
        'title' => $datum->title,
        'id' => $datum->id,
    ];
$users = [];
foreach ($usersData as $datum) {
    $mentor = \common\models\Mentor::find()->where(['user_id' => $datum->user_id])->one();
    if (!$mentor)
        $users[] = [
            'name' => $datum->user->email . ' ' . $datum->lastname . ' ' . $datum->firstname,
            'id' => $datum->user_id,
        ];
}
$members = [];
foreach ($membersData as $datum)
    $members[] = [
        'name' => $datum->user->email . ' ' . $datum->lastname . ' ' . $datum->firstname,
        'id' => $datum->user_id,
    ];
?>

<div class="user-form">
    <?php $form = ActiveForm::begin() ?>
        <div class="card">
            <div class="card-body">
                <?php if ($model->isNewRecord)
                {
                    echo $form->field($model, 'user_id')->dropDownList(\yii\helpers\ArrayHelper::map(
                        $users,
                        'id',
                        'name'
                    ), ['prompt' => '']);
                } ?>
                <?php echo $form->field($model, 'organization_id')->dropDownList(\yii\helpers\ArrayHelper::map(
                    $organizations,
                    'id',
                    'title'
                ), ['prompt' => '']) ?>
                <?php echo $form->field($model, 'organization_member_id')->dropDownList(\yii\helpers\ArrayHelper::map(
                    $members,
                    'id',
                    'name'
                ), ['prompt' => '']) ?>
                <?php echo $form->field($model, 'rating')->textInput() ?>
            </div>
            <div class="card-footer">
                <?php echo Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
        </div>
    <?php ActiveForm::end() ?>
</div>
