<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\time\TimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Schedule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="schedule-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'event_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\app\models\Events::find()->all(), 'event_id', 'name'),
        ['prompt'=>'']
    ) ?>

    <?=  $form->field($model, 'date')->widget(DatePicker::className(),[
        'name' => 'date',
        'removeButton' => false,
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true,
        ]
    ]); ?>

    <?=  $form->field($model, 'time_start')->widget(TimePicker::className(),[
        'name' => 'time_start',
        'pluginOptions' => [
            'showSeconds' => false,
            'showMeridian' => false,
            'minuteStep' => 30,
            'readonly' => true,
        ]
    ]); ?>

    <?=  $form->field($model, 'time_end')->widget(TimePicker::className(),[
        'name' => 'time_end',
        'pluginOptions' => [
            'showSeconds' => false,
            'showMeridian' => false,
            'minuteStep' => 30,
            'readonly' => true,
        ]
    ]); ?>

    <?= $form->field($model, 'room')->dropDownList(
        \yii\helpers\ArrayHelper::map(\app\models\Rooms::find()->all(), 'room_id', 'name'),
        ['prompt'=>'']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Utwórz' : 'Zapisz', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
