<?php

use app\models\Courier;
use yii\bootstrap\ButtonDropdown;
use yii\bootstrap\Nav;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CourierSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Все доставки';
?>
<?php Pjax::begin(); ?>
<div class="courier-shipping">
<div class="button-dropmenu">
<?= ButtonDropdown::widget([
    'label' => '+',
    'options' => [
        'class' => 'btn buttonAdd',
    ],
    'dropdown' => [
        'items' => [
            [
                'label' => 'Заказ',
                'url' => ['zakaz/create'],
                'visible' => Yii::$app->user->can('seeAdop'),
            ],
            [
                'label' => '',
                'options' => [
                    'role' => 'presentation',
                    'class' => 'divider'
                ]
            ],
            [
                'label' => 'Поломки',
                'url' => ['helpdesk/create']
            ],
            [
                'label' => '',
                'options' => [
                    'role' => 'presentation',
                    'class' => 'divider'
                ]
            ],
            [
                'label' => 'Задачи',
                'url' => ['todoist/create'],
            ],
            [
                'label' => '',
                'options' => [
                    'role' => 'presentation',
                    'class' => 'divider'
                ]
            ],
            [
                'label' => 'Доставка',
                'url' => ['courier/create'],
                'visible' => Yii::$app->user->can('admin'),
            ],
        ]
    ]
]); ?>
</div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'floatHeader' => false,
        'headerRowOptions' => ['class' => 'headerTable'],
        'pjax' => true,
        'tableOptions' 	=> ['class' => 'table table-bordered tableSize'],
        'striped' => false,
        'rowOptions' => ['class' => 'trShipping srok trNormal'],
        'columns' => [
            [
                'attribute' => 'date',
                'format' => ['date', 'php:d M'],
                'hAlign' => GridView::ALIGN_RIGHT,
                'contentOptions' => ['class' => 'border-left textTr tr70 srok'],
            ],
            [
                'attribute' => 'commit',
                'contentOptions'=>['style'=>'white-space: normal;'],
            ],
            [
                'attribute' => 'to',
                'format' => 'raw',
                'value' => function($courier){
                    return '<span class="shipping">Откуда: </span>'.$courier->to ;
                },
                'contentOptions' => ['class' => 'textTr tr202'],
            ],
            [
                'attribute' => 'from',
//                'hAlign' => GridView::ALIGN_RIGHT,
                'format' => 'raw',
                'contentOptions' => ['class' => 'textTr tr202'],
                'value' => function($courier){
                    return '<span class="shipping">Куда: </span>'.$courier->from ;
                },
            ],
            [
                'attribute' => 'id_zakaz',
                'value' => function($model){
                    return $model->id_zakaz != null ? Html::encode($model->idZakaz->prefics) : false;
                },
                'hAlign' => GridView::ALIGN_RIGHT,
                'contentOptions' => ['class' => 'textTr tr50', 'style' => 'border:none'],
            ],
            [
                'header' => '',
                'format' => 'raw',
                'value' => function($model){
                    /**
                     * Если курьер не взял доставку, то админ может в этом случае отменить
                     * в противном случае админ не сможет отменить */
                    if ($model->status == Courier::DOSTAVKA){
                        return Html::a('Удалить', ['deletes', 'id' => $model->id], [
                                'data' => ['confirm' => 'Вы действительно хотите удалить доставку?',
                                'method' => 'post']]);
                    } elseif($model->status == Courier::CANCEL){
                        return Html::encode('Отменен');
                    } else {
                        return '';
                    }
                },
                'contentOptions' => ['class' => 'textTr tr50 declined'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'contentOptions' => ['class' => 'border-right textTr tr50'],
            ]
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
<div class="footerNav">
    <?php echo Nav::widget([
        'options' => ['class' => 'nav nav-pills footerNav'],
        'items' => [
            ['label' => 'Архив', 'url' => ['courier/ready'], 'visible' => Yii::$app->user->can('admin')],
        ],
    ]); ?>
</div>