<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($user, 'username')->label('Логин') ?>

    <?= $form->field($user, 'last_name')->textInput(['maxlength' => true])->label('Фамилия') ?>

    <?= $form->field($user, 'name')->textInput(['maxlength' => true])->label('Имя') ?>

    <?= $form->field($user, 'patronymic')->textInput(['maxlength' => true])->label('Отчество') ?>

    <?= $form->field($user, 'id_position')->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\Position::find()->all(), 'id', 'name'))->label('Должность') ?>

    <?= $form->field($user, 'date_birth')->textInput(['type' => 'date']) ?>

    <?= $form->field($user, 'email') ?>

    <?= $form->field($user, 'password')->passwordInput()->label('Пароль') ?>

    <div class="form-group">
        <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
