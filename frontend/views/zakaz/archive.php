<?php

use app\models\Comment;
use kartik\grid\GridView;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ZakazSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Архив заказов';
?>
 
<div class="zakaz-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="col-xs-12">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'floatHeader' => true,
        'headerRowOptions' => ['class' => 'headerTable'],
        'pjax' => true,
        'tableOptions' 	=> ['class' => 'table table-bordered tableSize'],
        'rowOptions' => ['class' => 'trTable trNormal'],
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
                'attribute' => 'description',
                'value' => function($model){
                    return StringHelper::truncate($model->description, 100);
                }
            ],
            [
               'attribute' => 'restoring',
                'format' => 'raw',
                'contentOptions' => ['class' => 'tr50'],
                'value' => function($model){
                    if ($model->restoring == 1) {
                     return'<i class="fa fa-inbox" style="font-size: 13px;color: #5A4EF0;" aria-hidden="true" title="Востановленный заказ"></i>';
                    } else{
                        return '';
                    }
                }
            ],
            [
                'attribute' => 'id_shipping',
                'format' => 'raw',
                'contentOptions' => ['class' => 'tr50'],
                'value' => function($model){
                    if ($model->idShipping->status == 0 or $model->idShipping->status == 1) {
                        return '<i class="fa fa-truck" style="font-size: 13px;color: #f0ad4e; aria-hidden="true" title="В пути""></i>';
                    } elseif ($model->idShipping->status == 2){
                        return '<i class="fa fa-truck" style="font-size: 13px;color: #191412; aria-hidden="true" title="Доставлено"></i>';
                    } else{return '';}
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
                'value' => function(){
                    return '';
                },
                'contentOptions' => ['class' => 'textTr border-right tr20'],
            ],
        ],
    ]); ?>  
    </div>
</div>
