<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Otdel;
use app\models\Zakaz;
use dosamigos\datepicker\DatePicker;
use yii\widgets\ActiveForm;
use yii\bootstrap\Nav;
use yii\bootstrap\Modal;
use yii\widgets\MaskedInput;
use yii\grid\SetColumn;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ZakazSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказ';
?>
<?php Pjax::begin(); ?>
<?= Nav::widget([
    'options' => ['class' => 'nav nav-pills'],
    'items' => [
    ['label' => 'Главная', 'url' => ['zakaz/index']],
    ['label' => 'Администратор', 'url' => ['zakaz/admin']],
    ['label' => 'Закрытые заказы', 'url' => ['zakaz/archive']],
    ],
]); ?>
 
<div class="zakaz-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Создать заказ', ['create'], ['class' => 'btn btn-success']) ?>
        <?php //echo $this->render('_search', ['model' => $searchModel]);?>
        <?= Html::a('<span class="glyphicon glyphicon-refresh"></span>', ['zakaz/admin'], ['class' => 'btn btn-primary btn-lg pull-right']) ?>
    </p>

    <?php echo $this->render('_searchadmin', ['model' => $searchModel]);?>

    <!-- <?php var_dump($searchModel) ?> -->


    <div class="col-xs-12">
    
    <h3>Новые</h3>
    <?= GridView::widget([
        'dataProvider' => $dataProviderNew,
        'rowOptions' => function($model, $key, $index, $grid){
            return['style' => 'font-weight: bold;'];
        },
        'columns' => [
            [
                'attribute' => 'id_zakaz',
                'headerOptions' => ['width' => '20'],
                'value' => 'prefics',
            ],
            [
                'attribute' => 'description',
                'contentOptions'=>['style'=>'white-space: normal;'],
            ],
            //  [
            //     'attribute' => 'id_tovar',
            //     'value' => 'idTovar.name',
            //     'filter' => Zakaz::getTovarList(),
            //     'headerOptions' => ['width' => '100'],
            // ],
             [
                'attribute' => 'srok',
                'format' => ['datetime', 'php:d.m.Y'],
                'value' => 'srok',
                'filter' => DatePicker::widget([
                     'model' => $searchModel,
                     'attribute' => 'srok',
                     'inline' => false, 
                    'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy.mm.dd'
                ],
                ]),
                'headerOptions' => ['width' => '70'],
            ],
            [
                'attribute' => 'minut',
                'headerOptions' => ['width' => '10'],
            ],
            [
                'attribute' => 'fact_oplata',
                'headerOptions' => ['width' => '50'],
            ],
            [
                'attribute' => 'oplata',
                'headerOptions' => ['width' => '50'],
            ],
            [
                'attribute' => 'img',
                'format' => 'raw',
                
            ],
            [
                'attribute' => 'id_shipping',
                'value' => function($model){   
                    return $model->idShipping->dostavkaName;
                }
            ],
            [
                'attribute' => 'id_sotrud',
                'value' => 'idSotrud.name',
            ],
            [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view}',
            'buttons' => [
                'view' => function ($url,$model) {
                    return Html::a(
                    'Открыть', 
                    ['adopted', 'id' => $model->id_zakaz], ['class' => 'btn btn-primary btn-sm']);
                },
            ],
            ],
        ],
    ]); ?>  
    <h3>В работе</h3>
    <?= GridView::widget([
        'dataProvider' => $dataProviderWork,
        'rowOptions' => function($model, $key, $index, $grid){
            if ($model->srok < date('Y-m-d')) {
                return['style' => 'background: rgba(226, 0, 0, 0.48);'];

            }
        },
        'columns' => [
            [
                'attribute' => 'id_zakaz',
                'headerOptions' => ['width' => '20'],
                'value' => 'prefics',
            ],
            [
                'attribute' => 'status',
                'class' => SetColumn::className(),
                'format' => 'raw',
                'name' => 'statusName',
                'cssCLasses' => [
                    Zakaz::STATUS_EXECUTE => 'success',
                    Zakaz::STATUS_ADOPTED => 'warning',
                    Zakaz::STATUS_REJECT => 'danger',
                    Zakaz::STATUS_SUC_DISAIN => 'success',
                    Zakaz::STATUS_SUC_MASTER => 'success',
                ],
                'headerOptions' => ['width' => '50'],
            ],
            [
            'attribute' => 'description',
            'contentOptions'=>['style'=>'white-space: normal;'],
            ],
            //  [
            //     'attribute' => 'id_tovar',
            //     'value' => 'idTovar.name',
            //     'filter' => Zakaz::getTovarList(),
            //     'headerOptions' => ['width' => '100'],
            // ],
             [
                'attribute' => 'srok',
                'format' => ['datetime', 'php:d.m.Y'],
                'value' => 'srok',
                // 'filter' => DatePicker::widget([
                //      'model' => $searchModel,
                //      'attribute' => 'srok',
                //     // inline too, not bad
                //      'inline' => false, 
                //     'clientOptions' => [
                //     'autoclose' => true,
                //     'format' => 'yyyy.mm.dd'
                // ],
                // ]),
                'headerOptions' => ['width' => '70'],
            ],
            [
                'attribute' => 'minut',
                'headerOptions' => ['width' => '10'],
            ],
            [
                'attribute' => 'fact_oplata',
                'headerOptions' => ['width' => '50'],
            ],
            [
                'attribute' => 'oplata',
                'headerOptions' => ['width' => '50'],
            ],
            [
                'attribute' => 'img',
                'format' => 'raw',
                
            ],
            [
                'attribute' => 'id_sotrud',
                'value' => 'idSotrud.name',
            ],
            [
                'attribute' => 'id_shipping',
                'value' => function($model){   
                    return $model->idShipping->dostavkaName;
                }
            ],
            [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view}',
            'buttons' => [
                'view' => function ($url,$model) {
                    return Html::a(
                    'Открыть', 
                    $url, ['class' => 'btn btn-primary btn-sm']);
                },
            ],
            ],
        ],
    ]); ?>
    <h3>На исполнении</h3>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions' => function($model, $key, $index, $grid){
            if ($model->srok < date('Y-m-d')) {
                return['style' => 'background: rgba(226, 0, 0, 0.48);'];
            }
        },
        'columns' => [
            [
                'attribute' => 'id_zakaz',
                'headerOptions' => ['width' => '20'],
                'value' => 'prefics',
            ],
            [
                'attribute' => 'status',
                'class' => SetColumn::className(),
                'format' => 'raw',
                'name' => 'statusName',
                'cssCLasses' => [
                    Zakaz::STATUS_DISAIN => 'danger',
                    Zakaz::STATUS_SUC_DISAIN => 'success',
                    Zakaz::STATUS_MASTER => 'primary',
                    Zakaz::STATUS_SUC_MASTER => 'success',
                    Zakaz::STATUS_AUTSORS => 'info',
                ],
                'headerOptions' => ['width' => '50'],
            ],
            [
            'attribute' => 'description',
            'format' => 'text',
            'options' => ['width' => '200'],
            'contentOptions'=>['style'=>'white-space: normal;'],
            ],
            //  [
            //     'attribute' => 'id_tovar',
            //     'value' => 'idTovar.name',
            //     'filter' => Zakaz::getTovarList(),
            //     'headerOptions' => ['width' => '100'],
            // ],
             [
                'attribute' => 'srok',
                'format' => ['datetime', 'php:d.m.Y'],
                'value' => 'srok',
                'filter' => DatePicker::widget([
                     'model' => $searchModel,
                     'attribute' => 'srok',
                    // inline too, not bad
                     'inline' => false, 
                    'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy.mm.dd'
                ],
                ]),
                'headerOptions' => ['width' => '70'],
            ],
            [
                'attribute' => 'minut',
                'headerOptions' => ['width' => '10'],
            ],
            [
                'attribute' => 'fact_oplata',
                'headerOptions' => ['width' => '50'],
            ],
            [
                'attribute' => 'oplata',
                'headerOptions' => ['width' => '50'],
            ],
            [
                'attribute' => 'img',
                'format' => 'raw',
            ],
            [
                'attribute' => 'id_shipping',
                'value' => function($model){   
                    return $model->idShipping->dostavkaName;
                }
            ],
            [
                'attribute' => 'id_sotrud',
                'value' => 'idSotrud.name',
            ],
            [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view}',
            'buttons' => [
                'view' => function ($url,$model) {
                    return Html::a(
                    'Открыть', 
                    $url, ['class' => 'btn btn-primary btn-sm']);
                },
            ],
            ],
        ],
    ]); ?>
    <h3>На закрытие</h3>
    <?= GridView::widget([
        'dataProvider' => $dataProviderIspol,
        'columns' => [

            [
                'attribute' => 'id_zakaz',
                'headerOptions' => ['width' => '20'],
                'value' => 'prefics',
            ],
            [
            'attribute' => 'description',
            'headerOptions' => ['width' => '200'],
            ],
            //  [
            //     'attribute' => 'id_tovar',
            //     'value' => 'idTovar.name',
            //     'filter' => Zakaz::getTovarList(),
            //     'headerOptions' => ['width' => '100'],
            // ],
             [
                'attribute' => 'srok',
                'format' => ['datetime', 'php:d.m.Y'],
                'value' => 'srok',
                'filter' => DatePicker::widget([
                     'model' => $searchModel,
                     'attribute' => 'srok',
                    // inline too, not bad
                     'inline' => false, 
                    'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy.mm.dd'
                ],
                ]),
                'headerOptions' => ['width' => '70'],
            ],
            [
                'attribute' => 'minut',
                'headerOptions' => ['width' => '10'],
            ],
            [
                'attribute' => 'fact_oplata',
                'headerOptions' => ['width' => '50'],
            ],
            [
                'attribute' => 'oplata',
                'headerOptions' => ['width' => '50'],
            ],
            [
                'attribute' => 'img',
                'format' => 'raw',
                
            ],
            [
                'attribute' => 'id_shipping',
                'value' => function($model){   
                    return $model->idShipping->dostavkaName;
                }
            ],
            [
                'attribute' => 'id_sotrud',
                'value' => 'idSotrud.name',
            ],
            [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view}',
            'buttons' => [
                'view' => function ($url,$model) {
                    return Html::a(
                    'Открыть', 
                    $url, ['class' => 'btn btn-primary btn-sm']);
                },
            ],
            ],
        ],
    ]); ?> 
    <?php Pjax::end(); ?>
    </div>
</div>
