<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div>
    <?php $form = ActiveForm::begin([
        'id' => 'update-theme'
    ]) ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>