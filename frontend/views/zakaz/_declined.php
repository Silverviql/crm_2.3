<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin([
    'id' => 'form-declined'
]); ?>

<?= $form->field($model, 'declined')->textInput()->label(false) ?>

<?= Html::submitButton('Отправить', ['class' => 'action'])?>

<?php ActiveForm::end()?>
