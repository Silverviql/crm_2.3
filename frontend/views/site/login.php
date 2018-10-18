<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
// use kartik\widgets\ActiveForm;
// use kartik\label\LabelInPlace;
use yii\bootstrap\ActiveForm;

$this->title = 'Авторизация';
?>
<div class="site-login">

    <div class="row">
        <div class="col-lg-4 col-xs-1">

        </div>
        <div class="col-lg-4 col-xs-10">
            <div class="formLogin">
            <h1 class="titleLogin"><?= Html::encode($this->title) ?></h1>
            <?php $form = ActiveForm::begin(['id' => 'login-form',
            'enableClientValidation' => false,
            'enableClientScript' => false,
            'validateOnBlur' => false]); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => false, 'placeholder' => 'Логин', 'class' => 'inputFormLogin'])->label(false) ?>

                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Пароль', 'class' => 'inputFormPass'])->label(false) ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <div class="field-loginform-groupbutton">
                    <?= Html::submitButton('ВОЙТИ', ['name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
            </div>
        </div>
        <div class="col-lg-4 col-xs-1">

        </div>
    </div>

</div>
