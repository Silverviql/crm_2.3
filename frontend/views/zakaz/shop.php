<?php

use app\models\Comment;
use yii\bootstrap\Nav;
use yii\helpers\StringHelper;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\Zakaz;
use yii\bootstrap\ButtonDropdown;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ZakazSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $dataProviderExecute yii\data\ActiveDataProvider */

$this->title = 'ВСЕ ЗАКАЗЫ';
?>
<?php Pjax::begin(); ?>

<div class="zakaz-shop">
<div class="button-dropmenu">
    <?php echo ButtonDropdown::widget([
        'label' => '+',
        'options' => [
            'class' => 'btn buttonAdd',
        ],
        'dropdown' => [
            'items' => [
                [
                    'label' => 'Заказ',
                    'url' => 'zakaz/create',
                ],
                [
                    'label' => '',
                    'options' => [
                        'role' => 'presentation',
                        'class' => 'divider'
                    ]
                ],
                [
                    'label' => 'Закупки',
                    'url' => 'custom/create'
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
                    'url' => 'helpdesk/create'
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
//                            'visible' => Yii::$app->user->can('admin'),
                ],
            ]
        ]
    ]); ?>
    </div>
    <div class="col-lg-3 zakazSearch">
        <?php echo $this->render('_search', ['model' => $searchModel]);?>
    </div>
    <div class="col-lg-9 shopZakaz">
        <h3 class="titleTable">Исполнено</h3>
    </div>
    <div class="col-xs-12 ispolShop">
        <?= GridView::widget([
            'dataProvider' => $dataProviderExecute,
            'floatHeader' => true,
            'headerRowOptions' => ['class' => 'headerTable'],
            'pjax' => true,
            'striped' => false,
            'tableOptions' => ['class' => 'table table-bordered tableSize'],
            'rowOptions' => ['class' => 'trTable srok trNormal'],
            'columns' => [
                [
                    'class'=>'kartik\grid\ExpandRowColumn',
                    'contentOptions' => function($model){
                        return ['id' => $model->id_zakaz, 'class' => 'border-left', 'style' => 'border:none'];
                    },
                    'width'=>'10px',
                    'value' => function () {
                        return GridView::ROW_COLLAPSED;
                    },
                    'detail'=>function ($model) {
                        $comment = new Comment();
                        return Yii::$app->controller->renderPartial('_zakaz', ['model'=>$model, 'comment' => $comment]);
                    },
                    'enableRowClick' => true,
                    'expandOneOnly' => true,
                    'expandIcon' => ' ',
                    'collapseIcon' => ' ',
                ],
                [
                    'attribute' => 'id_zakaz',
                    'value' => 'prefics',
                    'hAlign' => GridView::ALIGN_RIGHT,
                    'contentOptions' => ['class' => 'textTr tr70'],
                ],
                 [
                'attribute' => '',
                'format' => 'raw',
                'contentOptions' => ['class' => 'tr20'],
                'value' => function($model){
                    if ($model->prioritet == 2) {
                            return '<i class="fa fa-circle fa-red" aria-hidden="true" title="Важно/Брак в заказе"></i>';
                    } elseif ($model->prioritet == 1) {
                        return '<i class="fa fa-exclamation-triangle fa-ping" aria-hidden="true" title="Очень важно"></i>';
                    } else {
                        return '';
                    }

                }
            ],
                [
                    'attribute' => 'srok',
                    'format' => ['datetime', 'php:d M H:i'],
                    'value' => 'srok',
                    'hAlign' => GridView::ALIGN_RIGHT,
                    'contentOptions' => ['class' => 'textTr tr100 srok'],
                ],
                [
                    'attribute' => 'minut',
                    'hAlign' => GridView::ALIGN_RIGHT,
                    'contentOptions' => ['class' => 'textTr tr10'],
                    'value' => function($model){
                        if ($model->minut == null){
                            return '';
                        } else {
                            return $model->minut;
                        }
                    }
                ],
                [
                    'attribute' => 'description',
                    'value' => function($model){
                        return StringHelper::truncate($model->description, 100);
                    }
                ],
                [
                 'attribute' => 'interior',
                'format' => 'raw',
                'contentOptions' => ['class' => 'tr50'],
                'value' =>  function($model){
                    if ($model->interior == 1) {
                        return '<i class="iconHolland" style="font-size: 13px;color: #5A4EF0;" aria-hidden="true" title="Внутренний заказ"></i>';
                        }else {
                              return '';
                        }
                    }
                 ],
                [
                    'attribute' => 'oplata',
                    'value' => 'money',
                    'hAlign' => GridView::ALIGN_RIGHT,
                    'contentOptions' => ['class' => 'textTr tr70'],
                ],
                [
                    'attribute' => '',
                    'format' => 'raw',
                    'value' => function($model){
                        if ($model->status == Zakaz::STATUS_EXECUTE){
                            return Html::a('Готово', ['close', 'id' => $model->id_zakaz]);
                        } else {
                            return '';
                        }
                    },
                    'contentOptions' => ['class' => 'textTr border-right tr70'],
                ]
            ],
        ]); ?>
    </div>
    <div class="col-lg-12">
        <h3 class="titleTable">В работе</h3>
    </div>
    <div class="col-xs-12">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'floatHeader' => true,
        'headerRowOptions' => ['class' => 'headerTable'],
        'pjax' => true,
        'striped' => false,
        'tableOptions' => ['class' => 'table table-bordered tableSize'],
        'rowOptions' => ['class' => 'trTable srok trNormal'],
        'columns' => [
            [
                'class'=>'kartik\grid\ExpandRowColumn',
                'contentOptions' => function($model){
                    return ['id' => $model->id_zakaz, 'class' => 'border-left', 'style' => 'border:none'];
                },
                'width'=>'10px',
                'value' => function () {
                    return GridView::ROW_COLLAPSED;
                },
                'detail'=>function ($model) {
                    $comment = new Comment();
                    return Yii::$app->controller->renderPartial('_zakaz', ['model'=>$model, 'comment' => $comment]);
                },
                'enableRowClick' => true,
                'expandOneOnly' => true,
                'expandIcon' => ' ',
                'collapseIcon' => ' ',
            ],
            [
                'attribute' => 'id_zakaz',
                'value' => 'prefics',
                'hAlign' => GridView::ALIGN_RIGHT,
                'contentOptions' => ['class' => 'textTr tr70'],
            ],
             [
                'attribute' => '',
                'format' => 'raw',
                'contentOptions' => ['class' => 'tr20'],
                'value' => function($model){
                    if ($model->prioritet == 2) {
                            return '<i class="fa fa-circle fa-red" aria-hidden="true" title="Важно/Брак в заказе"></i>';
                    } elseif ($model->prioritet == 1) {
                        return '<i class="fa fa-exclamation-triangle fa-ping" aria-hidden="true" title="Очень важно"></i>';
                    } else {
                        return '';
                    }

                }
            ],
            [
                'attribute' => 'srok',
                'format' => ['datetime', 'php:d M H:i'],
                'value' => 'srok',
                'hAlign' => GridView::ALIGN_RIGHT,
                'contentOptions' => ['class' => 'textTr tr100 srok'],
            ],
            [
                'attribute' => 'minut',
                'hAlign' => GridView::ALIGN_RIGHT,
                'contentOptions' => ['class' => 'textTr tr10'],
                'value' => function($model){
                    if ($model->minut == null){
                        return '';
                    } else {
                        return $model->minut;
                    }
                }
            ],
            [
                'attribute' => 'description',
                'value' => function($model){
                    return StringHelper::truncate($model->description, 100);
                }
            ],
            [
                 'attribute' => 'interior',
                'format' => 'raw',
                'contentOptions' => ['class' => 'tr50'],
                'value' =>  function($model){
                    if ($model->interior == 1) {
                        return '<i class="iconHolland" style="font-size: 13px;color: #5A4EF0;" aria-hidden="true" title="Внутренний заказ"></i>';
                        }else {
                              return '';
                        }
                    }
            ],
            [
                'attribute' => 'oplata',
                'value' => 'money',
                'hAlign' => GridView::ALIGN_RIGHT,
                'contentOptions' => ['class' => 'textTr tr70'],
            ],
            [
                'attribute' => '',
                'format' => 'raw',
                'value' => function($model){
                   if ($model->status == Zakaz::STATUS_EXECUTE){
                        return Html::a('Готово', ['close']);
                   } else {
                       return '';
                   }
                },
                'contentOptions' => ['class' => 'textTr border-right tr70'],
            ]
        ],
    ]); ?>
    </div>
    <?php Pjax::end(); ?>
</div>
<div class="footerNav">
    <?php echo Nav::widget([
        'options' => ['class' => 'nav nav-pills footerNav'],
        'items' => [
            ['label' => 'Архив', 'url' => ['zakaz/closezakaz'], 'visible' => Yii::$app->user->can('seeShop')],
        ],
    ]); ?>
</div>

