<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/** @var $model app\models\Zakaz */
/** @var $financy app\models\Financy */

$form = ActiveForm::begin([
        'action' => ['zakaz/draft', 'id' => $model->id_zakaz],
    ]); ?>

<div class="draftSum">
    <?= Html::encode('К доплате: ').number_format($model->oplata - $model->fact_oplata,0,',', ' ').' p.'?>
    <?= $form->field($financy, 'sum')->widget(MaskedInput::className(), [
        'clientOptions' => [
                'alias' => 'decimal',
                 'groupSeparator' => ' ',
                 'autoGroup' => true,
             ],
     ]); ?>
    <?= $form->field($financy, 'id_zakaz')->hiddenInput(['value' => $model->id_zakaz])->label(false) ?>
    <?= $form->field($financy, 'id_user')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>
    <?= Html::submitButton('Зачислить', ['class' => 'btn action']) ?>
</div>
<?php ActiveForm::end() ?>