<?php

use app\models\Zakaz;
use app\models\Partners;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
use kartik\datecontrol\DateControl;
use kartik\file\FileInput;
use yii\widgets\MaskedInput;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\Zakaz */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zakaz-form">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'enableClientScript' => false,
        'validateOnBlur' => false,
    ]); ?>

    <div class="col-xs-4 informationZakaz">
        <h3>Информация о заказе</h3>
        <div class="col-xs-8">    
        <?= $form->field($model, 'description')->textInput(['maxlength' => true, 'placeholder' => 'Описание', 'class' => 'inputForm'])->label(false) ?>
        </div>
        <div class="col-xs-4" id="zakaz-number1">
        <?= $form->field($model, 'number')->textInput(['type'=>'number','min' => '0', 'placeholder' => 'Кол-во', 'class' => 'inputForm'])->label(false) ?>
        </div>
        <div class="col-xs-12">
        <?= $form->field($model, 'information')->textarea(['rows' => 3, 'placeholder' => 'Дополнительная информация'])->label(false) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'file')->widget(FileInput::className(), [
                    'language' => 'ru',
                    'options' => ['multiple' => false],
                    'pluginOptions' => [
                        'theme' => 'explorer',
                        'showCaption' => false,
                        'showRemove' => false,
                        'showUpload' => false,
                        'showPreview' => true,
                        'browseClass' => 'action fileInput',
                        'browseLabel' =>  'Загрузить файл',
                        'previewFileType' => 'any',
                        'maxFileCount' => 1,
                        'maxFileSize' => 25600,
                        'preferIconicPreview' => true,
                        'previewFileIconSettings' => ([
                            'doc' => '<i class="fa fa-file-word-o text-orange"></i>',
                            'docx' => '<i class="fa fa-file-word-o text-orange"></i>',
                            'xls' => '<i class="fa fa-file-excel-o text-orange"></i>',
                            'xlsx' => '<i class="fa fa-file-excel-o text-orange"></i>',
                            'ppt' => '<i class="fa fa-file-powerpoint-o text-orange"></i>',
                            'pdf' => '<i class="fa fa-file-pdf-o text-orange"></i>',
                            'zip' => '<i class="fa fa-file-archive-o text-orange"></i>',
                            'rar' => '<i class="fa fa-file-archive-o text-orange"></i>',
                            'txt' => '<i class="fa fa-file-text-o text-orange"></i>',
                            'jpg' => '<i class="fa fa-file-photo-o text-orange"></i>',
                            'png' => '<i class="fa fa-file-photo-o text-orange"></i>',
                            'gif' => '<i class="fa fa-file-photo-o text-orange"></i>',
                        ]),
                        'layoutTemplates' => [
                            'preview' => '<div class="file-preview {class}">
                               <div class="{dropClass}">
                               <div class="file-preview-thumbnails">
                                </div>
                                <div class="clearfix"></div>
                                <div class="file-preview-status text-center text-success"></div>
                                <div class="kv-fileinput-error"></div>
                                </div>
                                </div>',
                            'actionDrag' => '<span class="file-drag-handle {dragClass}" title="{dragTitle}">{dragIcon}</span>',
                        ],
                    ]
            ])->label(false) ?>
            <div class="form-group field-zakaz-file">
            <?php if ($model->img == null) {
                $fileImg = '';
            } else {
                $fileImg = 'Файл: ' . $model->img;
            }
            ?>
            <?= Html::encode($fileImg) ?>
            </div>
             <?php if (Yii::$app->user->can('shop')): ?>
                <?= $form->field($model, 'prioritet')
                    ->checkbox([
                        'label' => 'Брак в заказе :',
                        'labelOptions' => [
                            'style' => 'padding-left:20px;'
                        ],
                         'style' => [
                            'float' => 'right;     margin: -4px 5px 0;'
                        ],

                    ]);
                ?>
     <!--           --><?/*= $form->field($model, 'prioritet')->dropDownList([
                    '1' => 'важно',
                    '2' => 'очень важно'],
                    ['prompt' => 'Выберите приоритет'])->label(false) */?>
            <?php endif ?>
              <?= $form->field($model, 'interior')
                ->checkbox([
                    'label' => 'Внутренний заказ :',
                    'labelOptions' => [
                        'style' => 'padding-left:20px;'
                    ],
                    'style' => [
                        'float' => 'right;     margin: -1px 2px 0;'
                    ],

                ]);
            ?>
        </div> 
    
        
    </div>
    

    <div class="col-xs-2 clientZakaz">
        <h3>Клиент</h3>
        <div class="col-xs-12">
        <?= $form->field($model, 'name')->textInput(['placeholder' => 'Имя клиента', 'class' => 'inputForm'])->label(false) ?>
        </div>
        <div class="col-xs-12">
        <?= $form->field($model, 'phone')->widget(MaskedInput::className(),[
            'mask' => '89999999999',
            'options' => ['placeholder' => 'Телефон', 'class' => 'inputWidget-contact'],
        ])->label(false) ?>
        </div>
         <div class="col-xs-12">
        <?= $form->field($model, 'email')->widget(MaskedInput::className(),[
            'clientOptions' => ['alias' => 'email'],
            'options' => ['placeholder' => 'Email', 'class' => 'inputWidget-contact'],
        ])->label(false) ?>
        </div>
    </div>

    <div class="col-xs-2 moneyZakaz">
        <h3>Оплата</h3>
         <?php if (Yii::$app->user->can('admin')): ?> 
            <div class="col-xs-10">
                <label>Всего:</label>
                <?= $form->field($model, 'oplata')->widget(MaskedInput::className(), [
                        'clientOptions' => [
                            'alias' => 'decimal',
                            'groupSeparator' => ' ',
                            'autoGroup' => true,
                        ],
                    'options' => ['placeholder' => 'Cтоимость', 'class' => 'inputWidget-form'],
                ])->label(false) ?>
            </div>
            <div class="col-xs-10">
                <label>Оплачено:</label>
               <?php if($model->id_shop == 5 || $model->id_shop == null): ?> 
                <?= $form->field($model, 'fact_oplata')->widget(MaskedInput::className(), [
                    'clientOptions' => [
                        'alias' => 'decimal',
                        'groupSeparator' => ' ',
                        'autoGroup' => true,
                    ],
                    'options' => ['placeholder' => 'Оплачено', 'class' => 'inputWidget-form'],
                ])->label(false) ?>
                <?php else: ?>
                     <?php if ($model->fact_oplata == 0  || $model->fact_oplata == null ): ?> 
                     <p><?php echo number_format(0, 0,',', ' ').' рублей'; ?></p>
                     <?php else: ?>
                         <p><?php echo number_format($model->fact_oplata, 0,',', ' ').' рублей'; ?></p>
                      <?php endif ?>
               <?php endif ?>
            </div>
            <div class="col-xs-10">
                <?php if($model->oplata != null){?>
                <label>К доплате:</label>
                <p><?php echo number_format($model->oplata - $model->fact_oplata, 0,',', ' ').' рублей'; ?></p>
                <?php } ?>
            </div>
        <?php endif ?>
         <?php if (Yii::$app->user->can('shop')): ?> 
            <div class="col-xs-10">
                <label>Всего:</label>
                     <?php if ($model->oplata == 0  || $model->oplata == null ): ?> 
                     <p><?php echo number_format(0, 0,',', ' ').' рублей'; ?></p>
                     <?php else: ?>
                <p><?php echo number_format($model->oplata, 0,',', ' ').' рублей'; ?></p>
                  <?php endif ?>
            </div>
            <div class="col-xs-10">
                 <label>Оплачено:</label>
                <?= $form->field($model, 'fact_oplata')->widget(MaskedInput::className(), [
                    'clientOptions' => [
                        'alias' => 'decimal',
                        'groupSeparator' => ' ',
                        'autoGroup' => true,
                    ],
                    'options' => ['placeholder' => 'Оплачено', 'class' => 'inputWidget-form'],
                ])->label(false) ?>
            </div>
            <div class="col-xs-10">
                <?php if($model->oplata != null){?>
                <label>К доплате:</label>
                <p><?php echo number_format($model->oplata - $model->fact_oplata, 0,',', ' ').' рублей'; ?></p>
                <?php } ?>
            </div>
        <?php endif ?>
    </div>

    <div class="col-xs-4 managmentZakaz">
           <h3>Управление</h3>
            <div class="col-xs-10">
                <?= $form->field($model, 'srok')->widget(DateControl::className(),
                    [
                        'convertFormat' => true,
                        'type'=>DateControl::FORMAT_DATETIME,
                        'displayFormat' => 'php:d M Y H:i',
                        'saveFormat' => 'php:Y-m-d H:i:s',
                        'widgetOptions' => [
                            'options' => ['placeholder' => 'Cрок']
                        ],
                    ])->label(false);?>
            </div>
            <?php if (Yii::$app->user->can('admin')): ?> 
<!--            <div class="col-xs-10">-->
<!--                --><?//= $form->field($model, 'id_tovar')->dropDownList(
//                    ArrayHelper::map(Tovar::find()->all(), 'id', 'name'),
//                ['prompt' => 'Выберите товар'])->label(false); ?>
<!--            </div>-->
            <div class="col-xs-10">   
             <?php if ($model->oplata === 0 || $model->fact_oplata === 0 || $model->oplata === null || $model->fact_oplata === null): ?> 
              <p>Заказ не олпачен, звони магазину.</p> 
                  <?php else: ?>
                    <?= $form->field($model, 'status')->dropDownList([
                Zakaz::STATUS_DESIGN => 'Дизайнер',
                Zakaz::STATUS_MASTER => 'Мастер',
                Zakaz::STATUS_AUTSORS => 'Аутсорс',
                ],
                ['prompt' => 'Назначить'])->label(false);?>
                <?= $form->field($model, 'id_autsors')->dropDownList(
                    ArrayHelper::map(Partners::find()->all(), 'id', 'name'),
                    [
                        'prompt' => 'Выберите партнера',
                        'id' => 'autsors'
                    ]
                )->label(false) ?>
                <?= $form->field($model, 'prioritet')->dropDownList([
                '1' => 'важно',
                '2' => 'очень важно'],
                ['prompt' => 'Выберите приоритет'])->label(false) ?>
                 
                 <?php endif ?>
            </div>
            <?php endif ?>
            <?php if (Yii::$app->user->can('shop')): ?>
            <div class="col-xs-10">
                <?= $form->field($model, 'sotrud_name')->textInput(['placeholder' => 'Сотрудник', 'class' => 'inputForm'])->label(false) ?>
            </div>
            <?php endif ?>
            <?php if(/*!$model->isNewRecord &&*/ Yii::$app->user->can('admin')): ?>
             <div class="col-xs-10">
                  <?php if($model->id_shop == 5 || $model->id_shop == null): ?>       
                    <?= $form->field($model, 'id_shop')->dropDownList(ArrayHelper::map(User::find()
                        ->selectUser()
                        ->all(),
                        'id', 'name'), [
                        'options' => [
                            5 => ['selected' => true] // Меняя цифру можно установить какой-либо элемент массива по умолчанию
                        ]
                    ])->label(false) ?>
             </div>
                    <?php else: ?>
                      <?= $form->field($model, 'id_shop')->dropDownList(ArrayHelper::map(User::find()
                        ->selectUserAdm()
                        ->all(),
                        'id', 'name'))->label(false) ?>
                    <?php endif ?>
            <?php endif; ?>
           <div class="col-xs-10">
               <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'action' : 'action']) ?>
           </div>
    </div>

    <!-- <?= $form->field($model, 'id_sotrud')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?> -->

    <!--<div class="col-xs-2 submitZakazForm">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'action' : 'action']) ?>
        </div>
    </div>-->
    <?php ActiveForm::end(); ?>
</div>
