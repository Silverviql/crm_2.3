<?php
use app\models\Zakaz;
use app\models\Partners;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin([
        'action' => ['zakaz/accept', 'id' => $model->id_zakaz],
]) ?>

<?= $form->field($model, 'status')->dropDownList([
    Zakaz::STATUS_DISAIN => 'Дизайнер',
    Zakaz::STATUS_MASTER => 'Мастер',
    Zakaz::STATUS_AUTSORS => 'Аутсорс',
])->label(false)?>

 <?php if($model->term_accept == null ):?>
        <?= $form->field($model, 'term_accept')->hiddenInput(['value' => $model->srok])->label(false) ?>
    <?php endif ?>

<?= $form->field($model, 'id_autsors')->dropDownList(
    ArrayHelper::map(Partners::find()->all(), 'id', 'name'),
    [
        'prompt' => 'Выберите партнера',
        'id' => 'autsors'
    ]
)->label(false) ?>

<?= Html::submitButton('Да', ['class' => 'action']) ?>

<?= Html::a('Никого не назначать', ['fulfilled', 'id' => $model->id_zakaz], ['class' => 'action fulfilled']) ?>

<?php ActiveForm::end() ?>
