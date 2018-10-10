<?php

use yii\helpers\Html;
use app\models\Courier;
use app\models\Zakaz;
use yii\grid\GridView;
use yii\bootstrap\Nav;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CourierSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Доставка';
?>
<?php Pjax::begin(); ?>  
<?php echo Nav::widget([
    'options' => ['class' => 'nav nav-pills'],
    'items' => [
    ['label' => 'Главная', 'url' => ['zakaz/index']],
    ['label' => 'Курьер', 'url' => ['courier/index']],
    ['label' => 'Готовые доставки', 'url' => ['courier/ready']],
    ],
]); ?>
<div class="courier-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- <div class="form-group" style="font-size: 16px;">
    <?php //ActiveForm::begin(); ?>
    <?php //foreach ($model as $shipping) {
        //echo '<div>№ заказа: '.$shipping->id_zakaz.'<br> откуда: '.$shipping->to.' <span>'.Html::submitButton('Принял', ['class' => 'btn btn-primary']).'</span><br> куда: '.$shipping->from.'<span>'.Html::submitButton('Доставил', ['class' => 'btn btn-success']).'</span><br> Информация: '.$shipping->commit.'</div><hr>';
    //}; ?>
    <?php //ActiveForm::end(); ?>
    </div> -->

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id_zakaz',
            [
                'attribute' => 'id_zakaz',
                'format' => 'text',
                'value' => 'idZakaz.description',
                'label' => 'Описание',
                'filter' => false,
            ],
            'to',
            'from',
            'commit',
            [
                'format' => 'raw',
                'value' => function($model, $key){
                    if ($model->data_to == '0000-00-00 00:00:00') {
                        return Html::a('Забрать', ['make', 'id' => $model->id], ['class' => 'btn btn-ptimary']);
                    } else {
                        return Html::a('Доставил', ['delivered', 'id' => $model->id], ['class' => 'btn btn-ptimary']);
                    }
                }
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
