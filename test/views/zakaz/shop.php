<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Otdel;
use app\models\Zakaz;
use dosamigos\datepicker\DatePicker;
use yii\bootstrap\Nav;
use yii\bootstrap\Modal;
// use yii\grid\SetColumn;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ZakazSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Экран - ВСЕ ЗАКАЗЫ';
?>
<?php Pjax::begin(); ?>

<?php echo Nav::widget([
    'options' => ['class' => 'nav nav-pills'],
    'items' => [
    ['label' => 'Главная', 'url' => ['zakaz/index']],
    ['label' => 'Прием заказов', 'url' => ['zakaz/shop'], 'visible' => Yii::$app->user->can('seeShop')],
    ['label' => 'Закрытые заказы', 'url' => ['zakaz/closezakaz']],
    ],
]); ?>
<div class="zakaz-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php echo $this->render('_search', ['model' => $searchModel]);?>
        <?= Html::a('<span class="glyphicon glyphicon-refresh"></span>', ['zakaz/shop'], ['class' => 'btn btn-primary btn-lg pull-right', 'style' => 'margin-left:10px;']) ?>
        <?= Html::a('Создать заказ', ['create'], ['class' => 'btn btn-success btn-lg pull-right',
        'style' => '']) ?>
    </p>
    <div class="col-xs-12">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'id_zakaz',
                'headerOptions' => ['width' => '20'],
                'value' => 'prefics',
            ],
            // [
            //     'attribute' => 'status',
            //     'class' => SetColumn::className(),
            //     'format' => 'raw',
            //     'name' => 'statusName',
            //     'cssCLasses' => [
            //         Zakaz::STATUS_NEW => 'primary',
            //         Zakaz::STATUS_EXECUTE => 'success',
            //         Zakaz::STATUS_ADOPTED => 'warning',
            //         Zakaz::STATUS_DISAIN => 'info',
            //         Zakaz::STATUS_SUC_DISAIN => 'success',
            //         Zakaz::STATUS_REJECT => 'danger',
            //         Zakaz::STATUS_MASTER => 'info',
            //         Zakaz::STATUS_SUC_MASTER => 'success',
            //         Zakaz::STATUS_AUTSORS => 'info',
            //     ],
            //     'headerOptions' => ['width' => '50'],
            // ],
            [
                'attribute' => 'description',
                'headerOptions' => ['width' => '550'],
                'contentOptions'=>['style'=>'white-space: normal;'],
            ],
            // [
            //     'attribute' => 'minut',
            //     'format' => ['time', 'php:H:i'],
            //     'headerOptions' => ['width' => '10'],
            // ],
            [
                'attribute' => 'fact_oplata',
                'label' => 'Предоплата',
                'headerOptions' => ['width' => '50'],
            ],
            [
                'attribute' => 'closePayment',
                'value' => function($model){
                return $model->fact_oplata == null ? $model->oplata - $model->fact_oplata: '0';
            },
                'headerOptions' => ['width' => '100'],
                'label' => 'К доплате',
            ],
            [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view}',
            'buttons' => [
                'view' => function ($url,$model) {
                    return Html::a('<button class = "btn btn-primary">Открыть</button>', $url);
                },
            ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
    </div>
</div>
