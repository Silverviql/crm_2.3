<?php

use yii\helpers\Html;
use app\models\Courier;
// use app\models\Zakaz;
use yii\grid\GridView;
use yii\bootstrap\Nav;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CourierSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Готовые доставки';
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

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'id_zakaz',
                'format' => 'text',
                // 'value' => 'idZakaz.description',
                'value' => $model->idZakaz->description,
            ],
            'to',
            'from',
        ],
    ]); ?>
<?php Pjax::end(); ?></div>