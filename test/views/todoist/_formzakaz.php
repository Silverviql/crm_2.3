<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Todoist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="todoist-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'srok')->widget(
        DatePicker::className(), [
            'inline' => false, 
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
    ])?>

    <?= $form->field($model, 'id_zakaz')->hiddenInput(['value' => Yii::$app->request->get('id_zakaz')])->label(false) ?>

    <?= $form->field($model, 'id_user')->dropDownList([
        '2' => 'Московский магазн',
        '6' => 'Пушкино',
        ]
    ) ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
