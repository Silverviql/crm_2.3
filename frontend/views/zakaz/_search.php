<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\ZakazSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="col-lg-7">
    <div class="zakaz-search">

        <?php $form = ActiveForm::begin([
            'method' => 'get',
        ]); ?>

        <!-- <?= $form->field($model, 'id_zakaz') ?> -->

        <!-- <?php if (Yii::$app->user->can('admin')): ?>
    <div class="col-xs-2">
        <?= $form->field($model, 'srok')->widget(
            DatePicker::className(), [
            'inline' => false,
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ]);?>
        <?= $form->field($model, 'data')->widget(
            DatePicker::className(), [
            'inline' => false,
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ]);?>
    </div>
    <?php endif ?> -->

        <?php if (Yii::$app->user->can('admin')): ?>

        <?= $form->field($model, 'id_sotrud')->dropDownList([
            '2' => 'Московский',
            '5' => 'Админ',
            '6' => 'Пушкина',
            '9' => 'Сибирский',
            '12' => 'Четаево',
            '16' => 'Карла Маркса',
        ],
            ['prompt' => 'Выберите магазин']
        ) ?>

    </div>
    <?php endif ?>



    <?= $form->field($model, 'phone')->textInput(['class' => 'form-control', 'placeholder' => 'Ваш запрос'])->label(false) ?>


    <!-- <?= Html::resetButton('Сбросить настройки', ['class' => 'btn btn-default']) ?> -->
    <?= Html::submitButton('<i class="fa fa-search" style="font-size: 20px;color: #544943; " aria-hidden="true"></i>', ['class' => 'btn btn-primary shopSearch']) ?>

    <?php ActiveForm::end(); ?>

</div>
