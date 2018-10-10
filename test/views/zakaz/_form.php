<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use app\models\Tovar;
use app\models\Zakaz;
use yii\helpers\ArrayHelper;
use yii\widgets\MaskedInput;
/* @var $this yii\web\View */
/* @var $model app\models\Zakaz */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zakaz-form">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <!-- <?= $form->field($model, 'id_zakaz')->textInput() ?> -->

    <!-- <?= $form->field($model, 'srok')->textInput() ?> -->
    <div class="col-xs-4">
        <h3>Информация о заказе</h3>
        <div class="col-xs-8">    
        <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-4">
        <?= $form->field($model, 'number')->textInput(['type'=>'number','min' => '0'])->label('Кол-во') ?>
        </div>
        <div class="col-xs-12">
        <?= $form->field($model, 'information')->textarea(['rows' => 5]) ?>
        </div>
        <div class="col-lg-5">
            <?= $form->field($model, 'file')->fileInput() ?>
            <?php  ?>
            <div class="form-group field-zakaz-file">
            <?php if ($model->img == null) {
                $fileImg = 'Нет выбранных файлов';
            } $fileImg = 'Файл: '.$model->img; ?>
            <?= Html::encode($fileImg) ?>
            </div>
        </div>   
    </div>

    <div class="col-xs-2">
        <h3>Клиент</h3>
        <div class="col-xs-12">
        <?= $form->field($model, 'name')->textInput()->label('Имя клиента') ?>
        </div>
        <div class="col-xs-12">
        <?= $form->field($model, 'phone')->widget(MaskedInput::className(),[
            'mask' => '89999999999'
        ]) ?>
        </div>
         <div class="col-xs-12">
        <?= $form->field($model, 'email')->widget(MaskedInput::className(),[
            'clientOptions' => ['alias' => 'email']
        ]) ?>
        </div>
    </div>

    <div class="col-xs-2">
        <h3>Оплата</h3>
        <div class="col-xs-10">
            <?= $form->field($model, 'oplata')->textInput(['type' => 'number', 'min' => '0']) ?>
        </div>
        <div class="col-xs-10">
         <?= $form->field($model, 'fact_oplata')->textInput(['type' => 'number', 'min' => '0'])->label('Предоплата') ?>
        </div>
        <div class="col-xs-10">
            <?php if($model->oplata != null){?>
            <label>К доплате</label>
            <p><?php echo $model->oplata - $model->fact_oplata.' рублей'; ?></p>
            <?php } ?>

        </div>
    </div>

    <div class="col-xs-4">
           <h3>Управление</h3>
            <div class="col-xs-6">
            <?= $form->field($model, 'srok')->widget(
                DatePicker::className(), [
                    'inline' => false, 
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
            ])->label('Срок');?>
            </div>
            <div class="col-xs-4">
            <?= $form->field($model, 'minut')->textInput(['type' => 'number', 'min' => '0', 'max' => '24']) ?>
            </div>
            <?php if (Yii::$app->user->can('admin')): ?> 
            <div class="col-xs-10">
                <?= $form->field($model, 'id_tovar')->dropDownList(
                    ArrayHelper::map(Tovar::find()->all(), 'id', 'name'),
                ['prompt' => 'Выберите товар']); ?>
            </div>
            <div class="col-xs-10">      
                <?= $form->field($model, 'status')->dropDownList([
                '2' => 'Принят',
                '3' => 'Дизайнер',
                '6' => 'Мастер',
                '8' => 'Аутсорс',
                '1' => 'Исполнен',
                ],
                ['prompt' => ''])->label('Назначить');?>
                <?= $form->field($model, 'prioritet')->dropDownList([
                '1' => 'важно',
                '2' => 'очень важно'],
                ['prompt' => 'Выберите приоритет']) ?>
            </div>
            <?php endif ?>
            <div class="col-xs-10">
                <?= $form->field($model, 'sotrud_name')->textInput() ?>
            </div>
    </div>

    <!-- <?= $form->field($model, 'id_sotrud')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?> -->


    <!-- <div class="col-xs-12">
    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>
    </div> -->

    <div class="col-xs-7" style="margin-top: 41px;margin-left: 14px;width: 672px;">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success btn-block btn-lg' : 'btn btn-primary btn-block btn-lg']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
