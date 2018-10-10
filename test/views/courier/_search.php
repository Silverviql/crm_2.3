<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CourierSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="courier-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_zakaz') ?>

    <?= $form->field($model, 'to') ?>

    <?= $form->field($model, 'data_to') ?>

    <?= $form->field($model, 'from') ?>

    <?php // echo $form->field($model, 'data_from') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
