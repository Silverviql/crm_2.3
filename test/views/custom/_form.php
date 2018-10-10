<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Custom */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="custom-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tovar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'number')->textInput(['type' => 'number', 'min' => '0']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
