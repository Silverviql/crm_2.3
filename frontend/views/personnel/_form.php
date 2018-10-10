<?php
use app\models\Position;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\PersonnelPosition */
/* @var $position app\models\Position */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="personnel-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'patronymic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->widget(MaskedInput::className(), [
        'mask' => '8(999)999-99-99',
    ]) ?>
    
     <?= $form->field($model, 'store')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'job_duties')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shedule')->dropDownList([
        '1' => '2/2',
        '2' => '5/2'],
        ['prompt' => 'Выберите график работы'
    ]) ?>

  <!--  <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bonus')->textInput(['type' => 'number']) ?>-->

    <?= $form->field($position, 'position_id')->dropDownList(ArrayHelper::map(Position::find()->all(), 'id', 'name'),
        [
            'prompt' => 'Выберите должность'
        ])->label('Должность') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
