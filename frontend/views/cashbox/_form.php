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
    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-xs-10">
        <?= $form->field($model, 'name')->textInput(['placeholder' => 'Имя', 'class' => 'inputForm'])->label(false) ?>
        <?= $form->field($model, 'surname')->textInput(['placeholder' => 'Фамилия', 'class' => 'inputForm'])->label(false) ?>
        <?= $form->field($model, 'shop')->hiddenInput(['value' => $nameShop])->label(false) ?>
        <?= $form->field($model, 'cash_on_cashbox')->textInput(['placeholder' => 'Наличные в кассе', 'class' => 'inputForm'])->label(false) ?>
        <?= $form->field($model, 'cash_on_check')->textInput(['placeholder' => 'Деньги по чеку', 'class' => 'inputForm'])->label(false) ?>
        <?= $form->field($model, 'non_cash')->textInput(['placeholder' => 'Безнал', 'class' => 'inputForm'])->label(false) ?>
        <?= $form->field($model, 'payment_from_cashbox')->textInput(['placeholder' => 'Выплаты из кассы', 'class' => 'inputForm'])->label(false) ?>
        <?= $form->field($model, 'to_which_payment')->textInput(['placeholder' => 'Почему выплачивали', 'class' => 'inputForm'])->label(false) ?>
        <?= $form->field($model, 'refunds')->textInput(['placeholder' => 'Возвраты:', 'class' => 'inputForm'])->label(false) ?>
        <?= $form->field($model, 'balance_in_cashbox')->textInput(['placeholder' => 'Остаток на завтр утро', 'class' => 'inputForm'])->label(false) ?>
        <?= $form->field($model, 'attendance')->textInput(['placeholder' => 'Счетчик посезаемости', 'class' => 'inputForm'])->label(false) ?>
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'action' : 'action']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>