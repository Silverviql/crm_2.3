<?php


use kartik\form\ActiveForm;
use yii\helpers\Html;

/** @var $model \app\models\Todoist */
?>

<?php $form = ActiveForm::begin([
    'id' => 'declinedTodoist-form'
]) ?>

<?= $form->field($model, 'declined')->textInput() ?>

<?= Html::submitButton('Отправить', ['class' => 'btn action']) ?>

<?php ActiveForm::end() ?>
