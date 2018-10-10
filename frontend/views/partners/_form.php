<?php

use app\models\Partners;
use frontend\components\YandexMap;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Partners */
/* @var $form yii\widgets\ActiveForm */

YandexMap::widget(['index' => 'partners']);
?>

<div class="partners-form">

    <?php $form = ActiveForm::begin([
        'id' => 'partnersForm'
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['id' => 'toMap']) ?>
    <?= $form->field($model, 'coordinate')->hiddenInput(['maxlength' => true, 'id' => 'toInput'])->label(false) ?>
    <?= $form->field($model, 'city')->hiddenInput(['maxlength' => true, 'id' => 'toCity'])->label(false) ?>
    <?= $form->field($model, 'street')->hiddenInput(['maxlength' => true, 'id' => 'toName'])->label(false) ?>

    <?= $form->field($model, 'room')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->widget(MaskedInput::className(), [
        'mask' => '8(999)999-99-99',
    ]) ?>
    
    <?= $form->field($model, 'whatsapp')->widget(MaskedInput::className(), [
        'mask' => '8(999)999-99-99',
    ]) ?>

    <?= $form->field($model, 'timetable')->widget(MaskedInput::className(), [
        'mask' => '09:00-18:00',
    ]) ?>

    <?= $form->field($model, 'contact_person')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->widget(MaskedInput::className(), [
        'clientOptions' => ['alias' => 'email'],
    ]) ?>

    <?= $form->field($model, 'web')->widget(MaskedInput::className(), [
        'clientOptions' => ['alias' => 'url'],
    ]) ?>

    <?= $form->field($model, 'specialization')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'active')->hiddenInput(['value' => Partners::ACTIVE])->label(false) ?>

    <?php if (!$model->isNewRecord): ?>
    <?= Html::a('Прекратить работать', ['close'], ['class' => 'btn btn-danger']) ?>
    <?php endif; ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>