<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Zakaz;
use app\models\Courier;
use app\models\Todoist;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Zakaz */

$this->title = $model->id_zakaz;
// $this->information = $model->description;
// $this->params['breadcrumbs'][] = ['label' => 'Все закакзы', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="zakaz-view">

    <h1><?= Html::encode($model->prefics.'. '.$model->description) ?></h1>
    <div style="margin-bottom: 10px; height: 112px">
        <div class="col-xs-5">
        <?php if (Yii::$app->user->can('shop')): ?>
        <?= Html::a('<span class = "glyphicon glyphicon-chevron-left"><span>', ['shop'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?php endif ?>
        <?php if (Yii::$app->user->can('master')): ?>
        <?= Html::a('<span class = "glyphicon glyphicon-chevron-left"><span>', ['master'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?php endif ?>
        <?php if (Yii::$app->user->can('disain')): ?>
        <?= Html::a('<span class = "glyphicon glyphicon-chevron-left"><span>', ['disain'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?php endif ?>
        <?php if (Yii::$app->user->can('admin')): ?>
        <?= Html::a('<span class = "glyphicon glyphicon-chevron-left"><span>', ['admin'], ['class' => 'btn btn-primary btn-sm']) ?> 
        <?php endif ?>

        <?php if (Yii::$app->user->can('master')): ?>
        <?= Html::a('Готово', ['check', 'id' => $model->id_zakaz], [
            'class' => 'btn btn-success btn-sm',
            'data' => [
                'confirm' => 'Вы уверены, что Вы выполнили работу?',
                'method' => 'post',
            ]
        ]); ?>
        <?php endif ?>

        <?php if (Yii::$app->user->can('admin')): ?>
        <?php 
        Modal::begin([
            'header' => '<h2>Доставка<h2>',
            'size' => 'modal-lg',
            'toggleButton' => [
                'tag' => 'button',
                'class' => 'btn btn-info btn-sm',
                'label' => 'Доставка',
            ],
        ]);


        echo $this->render('shipping', [
            'shipping' => $shipping,
            'model' => $model
            ]); 

        Modal::end(); ?>
        <?php endif ?>
        <?php if (Yii::$app->user->can('seeAdop')): ?>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id_zakaz], ['class' => 'btn btn-primary btn-sm']) ?>
        <?php endif ?>
        
        
        <!-- <?php if (Yii::$app->user->can('admin')){ ?>           
        <?= Html::a('Удалить', ['delete', 'id' => $model->id_zakaz], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить заказ?',
                'method' => 'post',
            ],
        ]) ?>
        <?php } ?> -->
        </div>
        <div class="col-xs-2">
        <?php if (Yii::$app->user->can('disain')): ?>

            
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'statusDisain')->dropDownList(
            ['0' => 'Новый',
            '1' => 'В работу',
            '2' => 'Согласование'],
            ['prompt' => 'Выберите статус']
        )->label(false); ?>

        <?= Html::submitButton('Установить статус', ['class' => 'btn btn-primary btn-sm']) ?>

        <?php ActiveForm::end(); ?>
        <?php endif ?>
        <?php if (Yii::$app->user->can('admin')): ?>
            
         <?php $form1 = ActiveForm::begin(); ?>

        <?= $form1->field($model, 'status')->dropDownList([
                '3' => 'Дизайнер',
                '6' => 'Мастер',
                '8' => 'Аутсорс',
                '1' => 'Исполнен',
                ],
                ['prompt' => 'Назначить'])->label(false);?>
        <?= Html::submitButton('Назначить', ['class' => 'btn btn-primary btn-sm']) ?>

        <?php ActiveForm::end(); ?>
        <?php endif ?>
        </div>
        <div class="col-xs-5">
        <?php if (Yii::$app->user->can('seeAdop')): ?>        
        <?= Html::a('Поставить задачу', ['todoist/createzakaz', 'id_zakaz' => $model->id_zakaz], ['class' => 'btn btn-primary btn-sm', 'style' => 'margin-left: 185px;']) ?>
        <?php endif ?>

        <?php if ($model->action == 0) { ?>

        <?= Html::a('Восстановить заказ', ['restore', 'id' => $model->id_zakaz], ['class' => 'btn btn-primary pull-right',
            'data' => [
                'confirm' => 'Вы действительно хотите восстановить заказ?',
                'method' => 'post',
            ],
            ]) ?>  
        <?php } ?>

        <?php if (Yii::$app->user->can('seeAdop')): ?>
            <?php if ($model->action == 1 && $model->status == 1): ?>
                <?= Html::a('Закрыть  заказ', ['close', 'id' => $model->id_zakaz], [
                    'class' => 'btn btn-primary pull-right',
                    'data' => [
                        'confirm' => 'Уверены, что заказ закрыт?',
                        'method' => 'post',
                    ]
                ]);  ?>
            <?php endif ?>
        <?php endif ?>
        </div>
    </div>

    <div class="col-xs-12">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id_zakaz',
            [
                'attribute' => 'srok',
                'visible' => Yii::$app->user->can('seeIspol'),
            ],
            [
                'attribute' => 'minut',
                'visible' => Yii::$app->user->can('admin'),
            ],
            [
                'attribute' => 'idSotrud.name',
                'label' => 'Магазин',
                'visible' => Yii::$app->user->can('admin'),
            ],
            [
                'attribute' => 'prioritetName',
                'label' => 'Приоритет',
                'visible' => Yii::$app->user->can('admin'),
            ],
            [
                'attribute' => 'statusName',
                'label' => 'Этап',
                'visible' => Yii::$app->user->can('admin'),
            ],
            [
                'attribute' => 'idTovar.name',
                'label' => 'Тип товара',
                'visible' => Yii::$app->user->can('admin'),
            ],
            [
                'attribute' => 'oplata',
                'visible' => Yii::$app->user->can('seeAdop'),
            ],
            'number',
            [
                'attribute' => 'data',
                'format' => ['date', 'php:d.m.Y H:i'],
                'visible' => Yii::$app->user->can('seeAdop'),
            ],
            'information',
            [
                'attribute' => 'img',
                'format' => 'raw',
                'value' => $model->img == null ? null : Html::a($model->img, '@web/attachment/'.$model->img, ['download' => true])
            ],
            [
                'attribute' => 'maket',
                'format' => 'raw',
                'value' => $model->maket == null ? null : Html::a($model->maket, '@web/maket/'.$model->maket, ['download' => true]),
                'visible' => $model->maket != null
            ],
            [
                'attribute' => 'statusDisainName',
                'visible' => Yii::$app->user->can('seeDisain') && $model->statusDisain != null,
                'label' => 'Статус у дизайнера',
            ],
            'name',
            'phone',
            [
                'attribute' => 'email',
                'visible' => Yii::$app->user->can('seeDisain'),
            ],
            [
                'attribute' => 'idShipping.dostavkaName',
                'label' => 'Доставка',
            ],
            // 'comment:ntext',
        ],
    ]) ?>
    </div>

    <?php if (Yii::$app->user->can('disain')) { ?>
    <div class="col-xs-12">
        <div class="col-xs-3">
        <?php $form = ActiveForm::begin([
            'options' => 
            [
                'class' => 'file',
                'enctype' => 'multipart/form-data'
            ]
        ]); ?>
        <?= $form->field($model, 'file')->fileinput(['class' => 'fileInput']) ?>
        </div>
        <?= Html::submitButton('Готово', ['class' => 'btn btn-success btn-lg col-xs-9']) ?>
        <?php ActiveForm::end(); ?>
    </div>
    <?php } ?>
</div>
