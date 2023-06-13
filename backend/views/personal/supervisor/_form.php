<?php

use common\models\User;
use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \common\models\Supervisor */
/* @var $form yii\bootstrap4\ActiveForm */


$directionsData = \common\models\InternshipDirection::find()->all();
$directions = [];
foreach ($directionsData as $datum)
    $directions[] = [
        'title' => $datum->title,
        'id' => $datum->id,
    ];
$usersData = \common\models\UserProfile::find()->where(['role' => \common\models\UserProfile::ROLE_SUPERVISOR])->all();
$users = [];
foreach ($usersData as $datum) {
    $supervisor = \common\models\Supervisor::find()->where(['user_id' => $datum->user_id])->one();
    if (!$supervisor)
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
                <?php echo $form->field($model, 'direction_id')->dropDownList(\yii\helpers\ArrayHelper::map(
                    $directions,
                    'id',
                    'title'
                ), ['prompt' => '']) ?>
                <?php echo $form->field($model, 'position')->textInput() ?>
            </div>
            <div class="card-footer">
                <?php echo Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
        </div>
    <?php ActiveForm::end() ?>
</div>
