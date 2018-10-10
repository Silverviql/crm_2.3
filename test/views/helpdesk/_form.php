<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Helpdesk */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="helpdesk-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <?= $form->field($model, 'id_user')->textInput() ?> -->

    <?= $form->field($model, 'commetnt')->textarea(['rows' => 6]) ?>

    <!-- <?= $form->field($model, 'status')->textInput() ?> -->

    <!-- <?= $form->field($model, 'date')->textInput() ?> -->

    <?= $form->field($model, 'sotrud')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
