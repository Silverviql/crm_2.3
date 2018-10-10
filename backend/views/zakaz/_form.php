<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Zakaz */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zakaz-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <?= $form->field($model, 'id_zakaz')->textInput() ?> -->

    <!-- <?= $form->field($model, 'srok')->textInput() ?> -->
    <?= $form->field($model, 'srok')->widget(
        DatePicker::className(), [
            // inline too, not bad
             'inline' => false, 
             // modify template for custom rendering
            // 'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
    ]);?>

    <?= $form->field($model, 'minut')->textInput() ?>

    <?= $form->field($model, 'id_sotrud')->dropDownList([
        '1' => 'Админ',
        '2' => 'Московский',
    ],
    [
        'prompt' => 'Выберите магазин',
    ]) ?>

   <!--  <?= $form->field($model, 'prioritet')->textInput(['maxlength' => true]) ?> -->

    <!-- <?= $form->field($model, 'status')->textInput() ?> -->

    <!-- <?= $form->field($model, 'id_tovar')->textInput() ?> -->

    <?= $form->field($model, 'oplata')->textInput(['type' => 'number', 'min' => '0']) ?>

    <?= $form->field($model, 'number')->textInput(['type'=>'number','min' => '0']) ?>

    <?= $form->field($model, 'data')->widget(
        DatePicker::className(), [
            // inline too, not bad
             'inline' => false, 
             // modify template for custom rendering
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
    ]);?>
    <!-- <?= $form->field($model, 'img')->fileInput() ?> -->

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'information')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'phone')->textInput() ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
