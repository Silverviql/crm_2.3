<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
// use app\models\Courier;
// use yii\models\Zakaz;
?>

<div class="zakaz-shippingForm">
	<?php $f = ActiveForm::begin(); ?>

	<?= $f->field($shipping, 'id_zakaz')->hiddenInput(['value' => $model])->label(false) ?>

    <?= $f-> field($shipping, 'commit')->textInput(['placeholder' => 'Что', 'class' => 'inputForm', 'style' => 'float:left'])->label(false) ?>

	<?= $f->field($shipping, 'date')->textInput(['type' => 'date', 'placeholder' => 'Что', 'class' => 'inputForm', 'style' => 'float:left;width: 39%;'])->label(false) ?>

	<?= $f->field($shipping, 'to')->textInput(['placeholder' => 'Откуда', 'class' => 'inputForm', 'style' => 'margin-top: 25px;'])->label(false) ?>

	<?= $f->field($shipping, 'from')->textInput(['placeholder' => 'Куда', 'class' => 'inputForm'])->label(false) ?>

	<div class="form-group">
		<?= Html::submitButton('Отправить', ['class' => 'action']) ?>
	</div>


	<?php ActiveForm::end(); ?>
</div>
