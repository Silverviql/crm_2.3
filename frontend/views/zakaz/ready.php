<?php

use app\models\Comment;
use app\models\Zakaz;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ZakazSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Готовые макеты';
?>
<?php Pjax::begin(); ?>

<div class="zakaz-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'floatHeader' => true,
        'headerRowOptions' => ['class' => 'headerTable'],
        'pjax' => true,
        'tableOptions' 	=> ['class' => 'table table-bordered tableSize'],
        'rowOptions' => function($model){
            if ($model->srok < date('Y-m-d') && $model->status > Zakaz::STATUS_NEW ) {
                return ['class' => 'trTable trTablePass italic trSrok'];
            } elseif ($model->srok < date('Y-m-d') && $model->status == Zakaz::STATUS_NEW) {
                return['class' => 'trTable trTablePass bold trSrok trNew'];
            } elseif ($model->srok > date('Y-m-d') && $model->status == Zakaz::STATUS_NEW){
                return['class' => 'trTable bold trSrok trNew'];
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
                'contentOptions' => ['class' => 'textTr tr50'],
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
                'contentOptions' => ['class' => 'textTr tr100 srok'],
            ],
            [
                'attribute' => 'minut',
                'hAlign' => GridView::ALIGN_RIGHT,
                'contentOptions' => ['class' => 'textTr tr10'],
            ],
            [
                'attribute' => 'description',
                'value' => function($model){
                    return StringHelper::truncate($model->description, 100);
                }
            ],
            [
                'attribute' => 'id_shipping',
                'format' => 'raw',
                'contentOptions' => ['class' => 'tr50'],
                'value' => function($model){
                    if ($model->idShipping->status == 0 or $model->idShipping->status == 1) {
                        return '<i class="fa fa-truck" style="font-size: 13px;color: #f0ad4e;"></i>';
                    } elseif ($model->idShipping->status == 2){
                        return '<i class="fa fa-truck" style="font-size: 13px;color: #191412;"></i>';
                    } else{return '';}
                }
            ],
            [
                'attribute' => 'oplata',
                'value' => 'money',
                'hAlign' => GridView::ALIGN_RIGHT,
                'contentOptions' => ['class' => 'textTr tr50'],
            ],
            [
                'attribute' => '',
                'format' => 'raw',
                'value' => function(){
                    return '';
                },
                'contentOptions' => ['class' => 'textTr tr20'],
            ],
            [
                'attribute' => 'time',
                'value' => function($model){
                    return $model->time.' минут';
                },
                'contentOptions' => ['class' => 'border-right textTr tr90'],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
