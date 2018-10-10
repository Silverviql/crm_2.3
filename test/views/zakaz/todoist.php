<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;
// use app\models\Courier;
// use yii\models\Zakaz;
?>

<div class="zakaz-shippingForm">
	<?php $f = ActiveForm::begin(); ?>

	<?= $f->field($todoist, 'id_zakaz')->hiddenInput(['value' => $model->id_zakaz])->label(false) ?>

	<?= $f->field($todoist, 'srok')->textInput() ?>

	<?= $f->field($todoist, 'id_user')->textInput() ?>

	<?= $f-> field($todoist, 'typ')->textInput()->label('Доп.указания (только для курьера)') ?>
	<?= $f->field($todoist, 'comment')->textInput() ?>

	<div class="form-group">
		<?= Html::submitButton('Создать доставку', ['class' => 'btn btn-primary']) ?>
	</div>


	<?php ActiveForm::end(); ?>
</div>