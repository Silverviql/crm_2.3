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
    <div class="col-xs-2">
        <?= $form->field($model, 'id_sotrud')->dropDownList([
                '2' => 'Московский',
                '5' => 'Админ',
                '6' => 'Пушкина',
                '9' => 'Сибирский',
                '12' => 'Четаево',
                '16' => 'Карла Маркса',
                '17' => 'Калинина',
            ],
            ['prompt' => 'Выберите магазин']
        ) ?>
        <?php //$form->field($model, 'status')->dropDownList(
            //ArrayHelper::map(User::find()->all(), 'id', 'name'),
        //['prompt' => 'Выберите этап',]); ?>
        
    </div>
    <?php endif ?>
    
<!--    <div class="col-xs-2">-->
<!--        --><?//= $form->field($model, 'name') ?>

        <?= $form->field($model, 'phone')->textInput(['class' => 'form-control', 'placeholder' => 'Введите номер телефона'])->label(false) ?>
<!--    </div>-->
    
    <div class="form-group col-xs-3" style="margin-top: 24px;">
        <!-- <?= Html::resetButton('Сбросить настройки', ['class' => 'btn btn-default']) ?> -->
        <?= Html::submitButton('Найти', ['class' => 'btn btn-primary shopSearch']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
