<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
switch (Yii::$app->user->id) {
    case '2'://изменение айди на название магазина
        $nameShop = "МСК";
        break;
    case '6'://изменение айди на название магазина
        $nameShop = "ПШК";
        break;
    case '9'://изменение айди на название магазина
        $nameShop = "СИБ";
        break;
    case '12'://изменение айди на название магазина
        $nameShop = "ЧЕТ";
        break;
    case '16'://изменение айди на название магазина
        $nameShop = "МРCК";
        break;
};
?>

<div class="partners-index">
    <?php $form = ActiveForm::begin([
        'id' => 'shippingZakaz',
    ]); ?>
    <div class="col-lg-6 cashboxForm">
        <?= $form->field($model, 'name')->textInput(['placeholder' => 'ФИО', 'class' => 'inputForm','autocomplete'=> 'off'])->label(false) ?>
        <?= $form->field($model, 'shop')->hiddenInput(['value' => $nameShop])->label(false) ?>
        <?= $form->field($model, 'cash_on_cashbox')->textInput(['placeholder' => 'Наличные в кассе', 'class' => 'inputForm','autocomplete'=> 'off'])->label(false) ?>
        <?= $form->field($model, 'cash_on_check')->textInput(['placeholder' => 'Наличные по чеку', 'class' => 'inputForm','autocomplete'=> 'off'])->label(false) ?>
        <?= $form->field($model, 'non_cash')->textInput(['placeholder' => 'Безналичные по чеку', 'class' => 'inputForm','autocomplete'=> 'off'])->label(false) ?>
       <!-- <?/*= $form->field($model, 'payment_from_cashbox')->textInput(['placeholder' => 'Выплаты из кассы', 'class' => 'inputForm'])->label(false) */?>
        --><?/*= $form->field($model, 'to_which_payment')->textInput(['placeholder' => 'На что выплачивали', 'class' => 'inputForm'])->label(false) */?>
        <?= $form->field($model, 'refunds')->textInput(['placeholder' => 'Возвраты по чеку', 'class' => 'inputForm','autocomplete'=> 'off'])->label(false) ?>
        <?= $form->field($model, 'balance_in_cashbox')->textInput(['placeholder' => 'Остаток в кассе', 'class' => 'inputForm','autocomplete'=> 'off'])->label(false) ?>
        <?= $form->field($model, 'attendance')->textInput(['placeholder' => 'Посетителей по счетчику', 'class' => 'inputForm','autocomplete'=> 'off'])->label(false) ?>
        <?= $form->field($model, 'boxberry_cash')->textInput(['placeholder' => 'Оплата Boxberry', 'class' => 'inputForm','autocomplete'=> 'off'])->label(false) ?>
        <?= $form->field($model, 'number_checks')->textInput(['placeholder' => 'Количество чеков', 'class' => 'inputForm','autocomplete'=> 'off'])->label(false) ?>
    </div>
    <div class="col-lg-6 textareaCashbox">
        <?= $form->field($model, 'what_learned')->textarea(['placeholder' => 'Чему я научился...', 'class' => 'textareaForm','autocomplete'=> 'off'])->label(false) ?>
        <?= $form->field($model, 'what_want_learn')->textarea(['placeholder' => 'Чему я хочу научиться...', 'class' => 'textareaForm','autocomplete'=> 'off'])->label(false) ?>
       <?= $form->field($model, 'what_need_upgrade')->textarea(['placeholder' => 'Что нужно улучшить в магазине...', 'class' => 'textareaForm','autocomplete'=> 'off'])->label(false) ?>
        <?= Html::submitButton('CОЗДАТЬ', ['class' => 'action']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php
$js = <<<JS
    $('#modalCashboxCreate').on('beforeSubmit', 'form', function(){
        alert('Напоминание создано!');
	 var data = $(this).serialize();
	 $.ajax({
	    url: '/cashbox/create', 
	    type: 'POST',
	    data: data,
	   /* success: function(res){
	       console.log(res);
	    },*/
	    error: function(){
	       alert('Error!');
	    }
	 });
	 $('#modalCashboxCreate').off('beforeSubmit', 'form');
	 $('#modalCashboxCreate').modal('hide'); //закрытие модального окна.
	 $('#modalCashboxCreate'). removeAttr ('tabindex');
	 return false;
     });
JS;
$this->registerJs($js);

?>