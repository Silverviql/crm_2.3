<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Helpdesk */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="helpdesk-form">

    <?php $form_help = ActiveForm::begin(); ?>

    <?= $form_help->field($helpdesk, 'commetnt')->textarea(['rows' => 6]) ?>

    <?= $form_help->field($helpdesk, 'sotrud')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($helpdesk->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $helpdesk->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
