<?php

use app\models\Comment;
use yii\bootstrap\Modal;
use yii\bootstrap\Nav;
use yii\helpers\StringHelper;
use kartik\grid\GridView;
use app\models\Zakaz;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ZakazSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $dataProviderSoglas yii\data\ActiveDataProvider */

$this->title = 'Все заказы';
?>
<?php Pjax::begin(['id' => 'pjax-container']); ?>

<div class="order-table">
    <div class="container order">
        <div class="row">
            <div class="col-lg-9 ispolShop">
                <h3 class="titleTable">В работе</h3>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'floatHeader' => false,
                    'headerRowOptions' => ['class' => 'headerTable'],
                    'pjax' => true,
                    'tableOptions' 	=> ['class' => 'table table-bordered tableSize'],
                    'rowOptions' => function($model){
                       /* if ($model->statusDesign == Zakaz::STATUS_DESIGNER_NEW) {
                            return ['class' => 'trTable trNormal trNewDesign'];
                        }*/
                         if ($model->srok < date('Y-m-d H:i:s')  ) {
                            return ['class' => 'trTable trTablePass italic trNewDesign'];
                        }else {
                            return ['class' => 'trTable trNormal trNewDesign'];
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
                            'attribute' => 'oplata',
                            'value' => 'money',
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'contentOptions' => ['class' => 'textTr tr70'],
                        ],
                        [
                            'attribute' => 'time',
                            'value' => function($model){
                                if ($model->time == null){
                                    return '0 минут';
                                } else {
                                    return $model->time.' минут';
                                }
                            },
                            'contentOptions' => ['class' => 'textTr tr70'],
                        ],
                        [
                            'attribute' => 'statusDesignName',
                            'contentOptions' => ['class' => 'border-right textTr tr90'],
                        ],
                    ],
                ]); ?>
                <h3 class="titleTable">На согласование</h3>
                <?= GridView::widget([
                    'dataProvider' => $dataProviderSoglas,
                    'floatHeader' => false,
                    'headerRowOptions' => ['class' => 'headerTable'],
                    'pjax' => true,
                    'tableOptions' 	=> ['class' => 'table table-bordered tableSize'],
                    'rowOptions' => function($model){
                        if ($model->statusDesign == Zakaz::STATUS_DESIGNER_NEW) {
                            return ['class' => 'trTable trNormal trNewDesign'];
                        } else {
                            return ['class' => 'trTable trNormal'];
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
                                    return '<i class="fa fa-circle fa-red"></i>';
                                } elseif ($model->prioritet == 1) {
                                    return '<i class="fa fa-circle fa-ping"></i>';
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
                            'contentOptions' => ['class' => 'textTr tr90'],
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
                            'attribute' => 'oplata',
                            'value' => 'money',
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'contentOptions' => ['class' => 'textTr tr70'],
                        ],
                        [
                            'attribute' => 'time',
                            'value' => function($model){
                                if ($model->time == null){
                                    return '0 минут';
                                } else {
                                    return $model->time.' минут';
                                }
                            },
                            'contentOptions' => ['class' => 'textTr tr70'],
                        ],
                        [
                            'attribute' => 'statusDesignName',
                            'contentOptions' => function($model) {
                                if ($model->status == Zakaz::STATUS_SUC_DESIGN) {
                                    return ['class' => 'border-right textTr tr90 success-ispol'];
                                } elseif($model->status == Zakaz::STATUS_DECLINED_DESIGN) {

                                    return ['class' => 'border-right textTr tr90'];
                                }
                            }
                        ],
                    ],
                ]); ?>
            </div>
            <div class="col-lg-3"></div>
        </div>
    </div>
</div>
    <?php Pjax::end(); ?>
</div>
<div class="footerNav">
    <?php echo Nav::widget([
        'options' => ['class' => 'nav nav-pills footerNav'],
        'items' => [
            ['label' => 'Архив', 'url' => ['zakaz/ready'], 'visible' => Yii::$app->user->can('design')],
        ],
    ]); ?>
</div>
<?php Modal::begin([
    'id' => 'modalFile',
    'size' => 'modal-sm',
    'header' => '<h2>Прикрепите макет</h2>',
]);

echo '<div class="modalContent"></div>';

Modal::end();?>
