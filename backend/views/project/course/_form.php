<?php

use common\models\User;
use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \common\models\Course */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $roles yii\rbac\Role[] */
/* @var $permissions yii\rbac\Permission[] */
?>

<div class="user-form">
    <?php $form = ActiveForm::begin() ?>
        <div class="card">
            <div class="card-body">
                <?php echo $form->field($model, 'title')->textInput() ?>
                <div style="display:flex; margin-bottom:8px;">
                    <div class="border border-secondary rounded p-1" style="width:320px">
                                        <?php echo $form->field($model, 'date_start')->widget(
                                            DateTimePicker::class,
                                            [
                                                'type' => DateTimePicker::TYPE_INLINE,
                                                'pluginOptions' => [
                                                    'format' => 'yyyy-mm-dd hh:ii',
                                                    'showMeridian' => true,
                                                    'todayBtn' => true,
                                                ]
                                            ]
                                        ) ?>
                                    </div>
                                    <div class="border border-secondary rounded p-1" style="width:320px; margin-left:12px;">
                                        <?php echo $form->field($model, 'date_end')->widget(
                                            DateTimePicker::class,
                                            [
                                                'type' => DateTimePicker::TYPE_INLINE,
                                                'pluginOptions' => [
                                                    'format' => 'yyyy-mm-dd hh:ii',
                                                    'showMeridian' => true,
                                                    'todayBtn' => true,
                                                ]
                                            ]
                                        ) ?>
                                    </div>
                </div>
                <?php echo $form->field($model, 'status')->dropDownList(\common\models\Course::statuses()) ?>
            </div>
            <div class="card-footer">
                <?php echo Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
        </div>
    <?php ActiveForm::end() ?>
</div>
