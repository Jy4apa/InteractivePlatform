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
                <div class="border border-secondary rounded p-1" style="width:320px">
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
                <?php echo $form->field($model, 'count')->textInput(['type' => 'number', 'step' => 1, 'min' => 0]) ?>
            </div>
            <div class="card-footer">
                <?php echo Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
        </div>
    <?php ActiveForm::end() ?>
</div>
