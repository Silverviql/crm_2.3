<?php

use app\models\Courier;
use app\models\Zakaz;
use app\models\Comment;
use yii\bootstrap\Nav;
use yii\helpers\StringHelper;
use yii\bootstrap\Modal;
use yii\bootstrap\ButtonDropdown;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ZakazSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/** @var $dataProviderWork yii\data\ActiveDataProvider */
/** @var $dataProviderIspol yii\data\ActiveDataProvider*/

$this->title = 'ВСЕ ЗАКАЗЫ';
?>

<div class="order-table">
    <div class="container order">
        <div class="row">
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
                    'url' => '#',
                    'options' => [
                        'class' => 'modalOrderCreate-button',
                        'value' => 'zakaz/create',
                        'id' => $model->id_zakaz,
                        'onclick' => 'return false'
                    ]
                ],
                [
                    'label' => '',
                    'options' => [
                        'role' => 'presentation',
                        'class' => 'divider'
                    ]
                ],
                [
                    'label' => 'Закупка',
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
                    'label' => 'Поломка',
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
                    'label' => 'Задача',
                    'url' => 'todoist/create'
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
                    'url' => 'courier/create'
                ],
            ]
        ]
    ]); ?>
            </div>
            <div class="col-lg-6"></div>
            <div class="col-lg-6 orderSearch">
                <?php echo $this->render('_search', ['model' => $searchModel]);?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9 orderTableBack">
                <h3 class="titleTable">В работе</h3>
                <?= GridView::widget([
        'dataProvider' => $dataProviderWork,
        'floatHeader' => false,
        'headerRowOptions' => ['class' => 'headerTable'],
        'pjax' => true,
        'id'=> 10,
        'tableOptions' 	=> ['class' => 'table table-bordered'],
        'rowOptions' => function($model){
            if ($model->srok < date('Y-m-d H:i:s') && $model->status > Zakaz::STATUS_NEW ) {
                return ['class' => 'trTable trTablePass italic trSrok'];
            } elseif ($model->srok < date('Y-m-d H:i:s') && $model->status == Zakaz::STATUS_NEW) {
                return['class' => 'trTable trTablePass bold trSrok trNew'];
            } elseif ($model->srok > date('Y-m-d H:i:s') && $model->status == Zakaz::STATUS_NEW){
                return['class' => 'trTable bold trSrok trNew'];
            } else {
                return ['class' => 'trTable srok trNormal'];
            }
        },
		'striped' => false,
        'columns' => [
			[
				'class'=>'kartik\grid\ExpandRowColumn',
                'contentOptions' => function($model){
                    return ['id' => $model->id_zakaz, 'class' => 'border-left', 'style' => 'border:none'];
                },                
				'width'=>'10px',
				'value' => function ($model, $key, $index) {
					return GridView::ROW_COLLAPSED;
				},
				'detail'=>function ($model, $key, $index, $column) {
                    $comment = new Comment();
					return Yii::$app->controller->renderPartial('_zakaz', ['model'=> $model, 'comment' => $comment]);
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
                'contentOptions' => function($model) {
                    if ($model->status == Zakaz::STATUS_NEW){
                        return ['class' => 'tr70'];
                    } else {
                        return ['class' => 'textTr tr70'];
                    }
                },
            ],
            [
                'attribute' => '',
                'format' => 'raw',
                'contentOptions' => ['class' => 'tr50'],
                'value' => function($model){
                    if ($model->prioritet == 2) {
                        return '<i class="fa fa-circle fa-red" aria-hidden="true" title="Важно/Брак в заказе"></i>';
                    } elseif ($model->prioritet == 1) {
                        return '<i class="fa fa-circle fa-ping" aria-hidden="true" title="Очень важно"></i>';
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
                'contentOptions' => function($model) {
                    if ($model->status == Zakaz::STATUS_NEW){
                        return ['class' => 'tr100 srok textSrok '];
                    } else {
                        return ['class' => 'textTr tr100 srok textSrok'];
                    }
                },
            ],
            [
                'attribute' => 'minut',
                'hAlign' => GridView::ALIGN_RIGHT,
                'contentOptions' => function($model) {
                    if ($model->status == Zakaz::STATUS_NEW){
                        return ['class' => 'tr10'];
                    } else {
                        return ['class' => 'textTr tr10'];
                    }
                },
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
                    return StringHelper::truncate($model->description, 53);
                },
                'contentOptions' => function ($model){
                    return ['class' => 'textTrDes', 'title' => $model->description];
                },
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
                'attribute' => 'id_shipping',
                'format' => 'raw',
                'contentOptions' => ['class' => 'tr50'],
                'value' => function($model){
                        if ($model->id_shipping == null or $model->id_shipping == null){
                            return '';
                        } else {
                            if ($model->idShipping->status == Courier::DOSTAVKA) {
                                return '<i class="fa fa-truck" style="font-size: 13px;color: #5A4EF0;" aria-hidden="true" title="На доставку"></i>';
                            }
                            elseif ($model->idShipping->status == Courier::RECEIVE){
                                return '<i class="fa fa-truck" style="font-size: 13px;color: #f0ad4e;" aria-hidden="true" title="В пути"></i>';
                            }
                            elseif ($model->idShipping->status == Courier::DELIVERED){
                                return '<i class="fa fa-truck" style="font-size: 13px;color: #191412;" aria-hidden="true" title="Доставлено"></i>';
                            } else {
                                return '';
                            }
                        }
                    }
            ],
            [
                'attribute' => 'oplata',
                'value' => function($model){
                    return number_format($model->oplata, 0,',', ' ').' р.';
                },
                'hAlign' => GridView::ALIGN_RIGHT,
                'contentOptions' => function($model) {
                    if ($model->status == Zakaz::STATUS_NEW){
                        return ['class' => 'tr70'];
                    } else {
                        return ['class' => 'textTr tr70'];
                    }
                },
            ],
            [
                'attribute' => '',
                'format' => 'raw',
                'value' => function($model){
                    return '';
                },
                'contentOptions' => ['class' => 'textTr border-right tr90'],
            ]
//            [
//                'attribute' => 'statusName',
//                'label' => 'Отв-ный',
//                'contentOptions' => ['class' => 'border-right'],
//            ],
//            [
//                'attribute' => 'status',
//                'class' => SetColumn::className(),
//                'label' => 'Отв-ный',
//                'format' => 'raw',
//                'name' => 'statusName',
//                'cssCLasses' => [
//                    Zakaz::STATUS_NEW => 'primary',
//                    Zakaz::STATUS_EXECUTE => 'success',
//                    Zakaz::STATUS_ADOPTED => 'warning',
//                    Zakaz::STATUS_REJECT => 'danger',
//                    Zakaz::STATUS_SUC_DESIGN => 'success',
//                    Zakaz::STATUS_SUC_MASTER => 'success',
//                ],
//                'contentOptions' => ['class' => 'border-right'],
//            ],
        ],
    ]); ?>
                <h3 class="titleTable">На исполнении</h3>
                <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'floatHeader' => false,
        'headerRowOptions' => ['class' => 'headerTable'],
        'pjax' => true,
         'id'=> 11,
        'tableOptions'  => ['class' => 'table table-bordered'],
        'striped' => false,

        'rowOptions' => function($model){
            if ($model->srok < date('Y-m-d H:i:s')) {
                return['class' => 'trTable trTablePass trNormal '];
            } else {
                return['class' => 'trTable srok trNormal'];
            }
        },
        'columns' => [
            [
                'class'=>'kartik\grid\ExpandRowColumn',
                'contentOptions' => function($model){
                    return ['id' => $model->id_zakaz, 'class' => 'border-left', 'style' => 'border:none'];
                }, 
                'width'=>'10px',
                'value' => function ($model, $key, $index) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail'=>function ($model, $key, $index, $column) {
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
                'contentOptions' => ['class' => 'tr50'],
                'value' => function($model){
                    if ($model->prioritet == 2) {
                        return '<i class="fa fa-circle fa-red" aria-hidden="true" title="Важно/Брак в заказе"></i>';
                    } elseif ($model->prioritet == 1) {
                        return '<i class="fa fa-circle fa-ping" aria-hidden="true" title="Очень важно"></i>';
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
                'contentOptions' => ['class' => 'textTr tr100 srok textSrok'],
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
                    return StringHelper::truncate($model->description, 65);
                },
                'contentOptions' => ['class' => 'textTrDes '],
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
                    'attribute' => 'id_shipping',
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'tr50'],
                    'value' => function($model){
                        if ($model->id_shipping == null or $model->id_shipping == null){
                            return '';
                        } else {
                            if ($model->idShipping->status == Courier::DOSTAVKA) {
                                return '<i class="fa fa-truck" style="font-size: 13px;color: #5A4EF0;" aria-hidden="true" title="На доставку"></i>';
                            }
                            elseif ($model->idShipping->status == Courier::RECEIVE){
                                return '<i class="fa fa-truck" style="font-size: 13px;color: #f0ad4e;" aria-hidden="true" title="В пути"></i>';
                            }
                            elseif ($model->idShipping->status == Courier::DELIVERED){
                                return '<i class="fa fa-truck" style="font-size: 13px;color: #191412;" aria-hidden="true" title="Доставлено"></i>';
                            } else {
                                return '';
                            }
                        }
                    }
            ],
            [
                'attribute' => 'oplata',
                'headerOptions' => ['width' => '70'],
                'value' => function($model){
                    return number_format($model->oplata,0, ',', ' ').' р.';
                },
                'hAlign' => GridView::ALIGN_RIGHT,
                'contentOptions' => ['class' => 'textTr tr70'],
            ],
            [
                'attribute' => 'statusName',
                'label' => 'Отв-ный',
                'contentOptions' => function($model) {
                    if ($model->id_unread == true && $model->srok < date('Y-m-d H:i:s')){
                        return ['class' => 'border-right /*success-ispol*/ trNew'];
                    } elseif ($model->id_unread == true && $model->srok > date('Y-m-d H:i:s')){
                        return ['class' => 'border-right /*success-ispol*/ trNew'];
                    } else {
                        return ['class' => 'border-right textTr'];
                    }
                },
            ],
        ],
    ]); ?>
                <h3 class="titleTable">На закрытие</h3>
                <?= GridView::widget([
                'dataProvider' => $dataProviderIspol,
                'floatHeader' => false,
                'headerRowOptions' => ['class' => 'headerTable'],
                'pjax' => true,
                 'id'=> 12,
                'striped' => false,
                'tableOptions' => ['class' => 'table table-bordered '],
                'rowOptions' => ['class' => 'trTable  trNormal'],
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
                        'contentOptions' => ['class' => 'tr50'],
                        'value' => function($model){
                            if ($model->prioritet == 2) {
                                return '<i class="fa fa-circle fa-red" aria-hidden="true" title="Важно/Брак в заказе"></i>';
                            } elseif ($model->prioritet == 1) {
                                return '<i class="fa fa-circle fa-ping" aria-hidden="true" title="Очень важно"></i>';
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
                        'contentOptions' => ['class' => 'textTr tr100 srok textSrok'],
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
                            return StringHelper::truncate($model->description, 65);
                        },
                        'contentOptions' => ['class' => 'textTrDes '],
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
                        'attribute' => 'id_shipping',
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'tr50'],
                        'value' => function($model){
                                if ($model->id_shipping == null or $model->id_shipping == null){
                                    return '';
                                } else {
                                    if ($model->idShipping->status == Courier::DOSTAVKA) {
                                        return '<i class="fa fa-truck" style="font-size: 13px;color: #5A4EF0;" aria-hidden="true"  title="На доставку"></i>';
                                    }
                                    elseif ($model->idShipping->status == Courier::RECEIVE){
                                        return '<i class="fa fa-truck" style="font-size: 13px;color: #f0ad4e;" aria-hidden="true"  title="В пути"></i>';
                                    }
                                    elseif ($model->idShipping->status == Courier::DELIVERED){
                                        return '<i class="fa fa-truck" style="font-size: 13px;color: #191412;" aria-hidden="true"  title="Доставлено"></i>';
                                    } else {
                                        return '';
                                    }
                                }
                            }
                    ],
                    [
                        'attribute' => 'oplata',
                        'value' => function($model){
                            return number_format($model->oplata,0, ',', ' ').' р.';
                        },
                        'hAlign' => GridView::ALIGN_RIGHT,
                        'contentOptions' => ['class' => 'textTr tr70'],
                    ],
                    [
                        'attribute' => '',
                        'format' => 'raw',
                        'value' => function(){
                            return '';
                        },
                        'contentOptions' => ['class' => 'textTr border-right tr90'],
                    ]
                ],
            ]); ?>
   <!-- --><?php /*Pjax::end(); */?>
            </div>
            <div class="col-lg-3"></div>
        </div>
    </div>
</div>

<div class="footer">
    <?php echo Nav::widget([
        'options' => ['class' => 'nav nav-pills footerNav'],
        'items' => [
            ['label' => 'Архив', 'url' => ['archive'], 'visible' => Yii::$app->user->can('seeAdmin')],
        ],
    ]); ?>
</div>
<?php Modal::begin([
    'id' => 'declinedModal',
    'header' => '<h2>Укажите причину отказа:</h2>',
]);

echo '<div class="modalContent"></div>';

Modal::end();?>
<?php Modal::begin([
    'id' => 'acceptdModal',
    'header' => '<h2>Назначить ответственного:</h2>',
]);

echo '<div class="modalContent"></div>';

Modal::end();?>
<?php Modal::begin([
    'id' => 'modalOrderCreate',
    'header' => '<h2>Отчет по кассе</h2>'
]);
echo '<div class="modalContent"></div>';
Modal::end(); ?>
<?php Modal::begin([
    'id' => 'modalOrderUpdate',
    'header' => '<h2>Отчет по кассе</h2>'
]);
echo '<div class="modalContent"></div>';
Modal::end(); ?>

