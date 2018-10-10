<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
// use kartik\widgets\ActiveForm;
// use kartik\label\LabelInPlace;
use yii\bootstrap\ActiveForm;

$this->title = 'Авторизация';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <div class="row">
        <div class="col-lg-3 formLogin">
            <h1 class="titleLogin"><?= Html::encode($this->title) ?></h1>
            <?php $form = ActiveForm::begin(['id' => 'login-form',
            'enableClientValidation' => false,
            'enableClientScript' => false,
            'validateOnBlur' => false]); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => false, 'placeholder' => 'Логин', 'class' => 'inputForm'])->label(false) ?>

                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Пароль', 'class' => 'inputForm'])->label(false) ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <!-- <div style="color:#999;margin:1em 0">
                    If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
                </div> -->

                <div class="form-group">
                    <?= Html::submitButton('Войти', ['name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <!-- <div class="footerLogin">
        <img src="img/logo.png" title="Logo">
        <div>Сеть магазинов</div>
        <div>&copy Holland <?php echo date('Y') ?></div>
    </div> -->
</div>
