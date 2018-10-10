<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ZakazSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zakaz-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_zakaz') ?>

    <?= $form->field($model, 'srok') ?>

    <?= $form->field($model, 'id_sotrud') ?>

    <?= $form->field($model, 'prioritet') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'id_tovar') ?>

    <?php // echo $form->field($model, 'oplata') ?>

    <?php // echo $form->field($model, 'number') ?>

    <?php // echo $form->field($model, 'data') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'information') ?>

    <?php // echo $form->field($model, 'id_client') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
