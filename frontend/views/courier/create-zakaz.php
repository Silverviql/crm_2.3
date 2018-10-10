<?php
use kartik\widgets\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $shipping app\models\Courier */
/** @var $model app\models\Zakaz */
$this->registerJsFile('@web/js/yandexMap.js');
?>

<div class="zakaz-shippingForm">
    <?php $f = ActiveForm::begin(); ?>

    <?= $f->field($shipping, 'id_zakaz')->hiddenInput(['value' => $model])->label(false) ?>

    <?= $f-> field($shipping, 'commit')->textInput(['placeholder' => 'Что', 'class' => 'inputForm', 'style' => 'float:left'])->label(false) ?>

    <?= $f->field($shipping, 'date')->widget(DateTimePicker::className() ,[
        'pluginOptions' => [
            'autoclose'=>true,
            'startDate' => 'php Y-m-d H:i:s',
            'todayBtn' => true,
            'todayHighlight' => true,
        ],
        'options' => [
            'placeholder' => 'Срок',
        ],
    ])->label(false) ?>

    <?= $f->field($shipping, 'toYandexMap')->textInput(['placeholder' => 'Откуда', 'id' => 'toMap', 'class' => 'inputForm', 'style' => 'margin-top: 25px;'])->label(false) ?>
    <?= $f->field($shipping, 'to')->hiddenInput(['maxlength' => true, 'id' => 'toInput'])->label(false) ?>
    <?= $f->field($shipping, 'to_name')->hiddenInput(['maxlength' => true, 'id' => 'toName'])->label(false) ?>

    <?= $f->field($shipping, 'fromYandexMap')->textInput(['placeholder' => 'Куда', 'id' => 'fromMap','class' => 'inputForm'])->label(false) ?>
    <?= $f->field($shipping, 'from')->hiddenInput(['maxlength' => true, 'id' => 'fromInput'])->label(false) ?>
    <?= $f->field($shipping, 'from_name')->hiddenInput(['maxlength' => true, 'id' => 'fromName'])->label(false) ?>


    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'action']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
