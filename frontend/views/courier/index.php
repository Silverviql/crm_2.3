<?php

use yii\helpers\Html;
use app\models\Courier;
use kartik\grid\GridView;
use yii\bootstrap\Nav;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CourierSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Все доставки';
?>
<?php Pjax::begin(); ?>
<div class="courier-index">

    <!-- <div class="form-group" style="font-size: 16px;">
    <?php //ActiveForm::begin(); ?>
    <?php //foreach ($model as $shipping) {
        //echo '<div>№ заказа: '.$shipping->id_zakaz.'<br> откуда: '.$shipping->to.' <span>'.Html::submitButton('Принял', ['class' => 'btn btn-primary']).'</span><br> куда: '.$shipping->from.'<span>'.Html::submitButton('Доставил', ['class' => 'btn btn-success']).'</span><br> Информация: '.$shipping->commit.'</div><hr>';
    //}; ?>
    <?php //ActiveForm::end(); ?>
    </div> -->

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
                'value' => function($model){
                    return $model->id_zakaz != null ? Html::encode($model->idZakaz->prefics) : false;
                },
                'hAlign' => GridView::ALIGN_RIGHT,
                'contentOptions' => ['class' => 'border-left textTr tr70', 'style' => 'border:none'],
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
                'format' => 'raw',
                'value' => function($courier){
                    return '<span class="shipping">Откуда: </span>'.$courier->to ;
                },
                'contentOptions' => ['class' => 'textTr tr202'],
            ],
            [
                'attribute' => 'from',
                'format' => 'raw',
                'contentOptions' => ['class' => 'textTr tr180'],
                'value' => function($courier){
                    return '<span class="shipping">Куда: </span>'.$courier->from ;
                },
            ],
            [
                'format' => 'raw',
                'value' => function($model){
                    if ($model->status == Courier::DOSTAVKA) {
                        return Html::a('Забрать', ['make', 'id' => $model->id]);
                    } elseif($model->status == Courier::RECEIVE) {
                        return Html::a('Доставил', ['delivered', 'id' => $model->id]);
                    } elseif($model->status == Courier::CANCEL){
                        return 'Доставка отменена';
                    }
                },
                'contentOptions' => ['class' => 'border-right textTr tr50'],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
<div class="footerNav">
    <?php echo Nav::widget([
        'options' => ['class' => 'nav nav-pills footerNav'],
        'items' => [
            ['label' => 'Архив', 'url' => ['courier/ready'], 'visible' => Yii::$app->user->can('courier')],
        ],
    ]); ?>
</div>