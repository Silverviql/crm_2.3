<?php

use app\models\Courier;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CourierSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Готовые доставки';
?>
<?php Pjax::begin(); ?>  

<div class="courier-index">
    <?php echo $this->render('_search', ['model' => $searchModel]) ?>

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'floatHeader' => true,
        'headerRowOptions' => ['class' => 'headerTable'],
        'pjax' => true,
        'tableOptions' 	=> ['class' => 'table table-bordered tableSize'],
        'striped' => false,
        'rowOptions' => ['class' => 'trTable srok trNormal'],
        'columns' => [
            [
                'attribute' => 'id_zakaz',
                'value' => 'idZakaz.prefics',
                'hAlign' => GridView::ALIGN_RIGHT,
                'contentOptions' => ['class' => 'border-left textTr tr50', 'style' => 'border:none'],
            ],
            [
                'attribute' => 'date',
                'format' => ['date', 'php:d M'],
                'hAlign' => GridView::ALIGN_RIGHT,
                'contentOptions' => ['class' => 'textTr tr70 srok'],
            ],
            [
                'attribute' => 'commit',
                'contentOptions'=>['style'=>'white-space: normal;'],
            ],
            [
                'attribute' => 'to',
                'hAlign' => GridView::ALIGN_RIGHT,
                'format' => 'raw',
                'value' => function($courier){
                    return '<span class="shipping">Откуда: </span>'.$courier->to ;
                },
                'contentOptions' => ['class' => 'textTr tr180'],
            ],
            [
                'attribute' => 'from',
                'hAlign' => GridView::ALIGN_RIGHT,
                'format' => 'raw',
                'contentOptions' => ['class' => 'textTr tr180'],
                'value' => function($courier){
                    return '<span class="shipping">Куда: </span>'.$courier->from ;
                },
            ],
            [
                'attribute' => 'status',
                'hAlign' => GridView::ALIGN_RIGHT,
                'contentOptions' => ['class' => 'border-right textTr tr50'],
                'value' => function($model){
                    return $model->status == Courier::CANCEL ? 'Отменена' : '';
                }
            ]
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
