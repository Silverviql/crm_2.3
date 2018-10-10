<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\ZakazSearch */

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use frontend\models\NumberColumn;

$dataProvider = new ActiveDataProvider([
    'query' => \app\models\Zakaz::find()
        ->where('action <= 0') ->andWhere( 'date_close >= (CURDATE()-1) AND date_close < CURDATE()')
        ->groupBy('date_close'),
    'pagination' => [
        'pageSize' => 10,
    ],
]);

$Articles = new ActiveDataProvider([
    'query' => \app\models\Zakaz::find()
        ->where('action <= 0') ->andWhere('date_close >= DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)'),
    
]);
$this->title = 'За неделю';
$this->params['breadcrumbs'][] = $this->title;
print_r ($arrayInView);

?>
<div id="analytic"  class="site-about">
    <h1><?= Html::encode('Вчера') ?></h1>
    <?php $array_of_models = $dataProvider->getModels();
    echo "<div class='analyticdata'>".count($array_of_models)."</div >"; //количество
    $someMyCol = ArrayHelper::getColumn($array_of_models,'fact_oplata');
    echo "<div  class='analyticdata'>".array_sum($someMyCol)."</div >";//сумма
    ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php $array_of_models = $Articles->getModels();
    echo "<div  class='analyticdata'>".count($array_of_models)."</div >"; //количество
    $someMyCol = ArrayHelper::getColumn($array_of_models,'fact_oplata');
    echo "<div class='analyticdata''>".array_sum($someMyCol)."</div >";//сумма
    ?>


    <h1><?= Html::encode('Вчера подробно') ?></h1>
    <?php $date_yesterday = new DateTime('-1 day');

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'showFooter' => true,
        'filterModel'=>$searchModel,
        'showPageSummary'=>false,
        'pjax'=>true,
        'striped'=>true,
        'hover'=>true,
         'options' => [
            'class' => 'analyticsOrderTable',
         ],
        'panel'=>['type'=>'primary', 'heading'=>$date_yesterday->format('d-M')],
        'columns' => [
            /*         [

                         'attribute'=>'date_close',
                         'format' => ['date', ' dd.MM.YYYY'],
                         'width'=>'310px',
                         'value'=>function ($model, $key, $index, $widget) {
                             return $model->date_close;
                         },

                         'filterType'=>GridView::FILTER_SELECT2,
                         'filter'=>ArrayHelper::map(\app\models\Zakaz::find()->orderBy('date_close')->asArray()->all(), 'id_zakaz', 'date_close'),
                         'filterWidgetOptions'=>[
                             'pluginOptions'=>['allowClear'=>true],
                         ],
                         'filterInputOptions'=>['placeholder'=>'Any supplier'],
                         'group'=>true, // enable grouping
                     ],*/
            [
                'attribute' => 'description',
                'contentOptions' =>['style'=>'color:black;'],
            ],
            [
                'attribute' => 'id_shop',
                'contentOptions' =>['style'=>'color:black;'],
            ],
            [
                'attribute' => 'number',
                'contentOptions' =>['style'=>'color:black;'],
            ],
            [
                /*'class'=>'kartik\grid\FormulaColumn',*/
                'header'=>'Сколько дней',
                'value'=>function ($model, $key, $index, $widget) {
                    return  (strtotime ($model->date_close)-strtotime ($model->data))/(60*60*24);;
                },
                'width'=>'150px',
                'hAlign'=>'right',
                'format'=>['decimal', 0 ],
                'contentOptions' =>['style'=>'color:black;'],
            ],
            [
                'header'=>'Итого',
                /* 'class' => NumberColumn::className(),*/
                'attribute' => 'fact_oplata',
                'contentOptions' =>['style'=>'color:black;'],
                'value'=>function ($model, $key, $index, $widget) {

                    return $model->fact_oplata;
                },
            ],


        ],
    ]);;?>
    <h1><?= Html::encode('Неделя по дням') ?></h1>
    </div>
    <?php
    $date_start = new DateTime('-1 day');
    $date_finish = new DateTime('-7 day');
    $array_of_models = $Articles->getModels();
    count($array_of_models);
    $someMyCol = ArrayHelper::getColumn($array_of_models,'fact_oplata');
    array_sum($someMyCol);
    echo GridView::widget([
        'dataProvider' => $Articles,
        'showFooter' => true,
        'filterModel'=>$searchModel,
        'showPageSummary'=>false,
        'pjax'=>true,
        'striped'=>true,
        'hover'=>true,
         'options' => [
            'class' => 'analyticsOrderTable',
         ],

        'panel'=>['type'=>'primary', 'heading'=>$date_finish->format('d-M').' - '. $date_start->format('d-M') ],
        'columns' => [
            [
                'attribute'=>'date_close',
                'contentOptions' =>['style'=>'color:black;'],
                'format' => ['date', ' dd.MM.YYYY'],
                'width'=>'310px',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->date_close;
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(\app\models\Zakaz::find()->orderBy('date_close')->asArray()->all(), 'id_zakaz', 'date_close'),
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Any supplier'],
                'group'=>true, // enable grouping
                'subGroupOf'=>3, // supplier column index is the parent group,
                'groupFooter'=>function ($model, $key, $index, $widget) { // Closure method
                    return [
                        'content'=>[              // content to show in each summary cell
                            1=>GridView::F_SUM,
                            2=>GridView::F_SUM,
                        ],
                        'contentFormats'=>[      // content reformatting for each summary cell
                            1=>['format'=>'number', 'decimals'=>0],
                            2=>['format'=>'number', 'decimals'=>0],
                        ],
                        'contentOptions'=>[      // content html attributes for each summary cell


                        ],
                        // html attributes for group summary row
                        'options'=>['class'=>'success','style'=>'font-weight:bold;  color:black;']
                    ];
                },
            ],
            [
                /*'class'=>'kartik\grid\FormulaColumn',*/
                'header'=>'Заказов',
                'contentOptions' =>['style'=>'color:black;'],
                'value'=>function ($model, $key, $index, $widget) {
                    return  count($model->fact_oplata);
                },
                'width'=>'150px',

                'format'=>['decimal', 0],
            ],
            [
                /*'class'=>'kartik\grid\FormulaColumn',*/
                'header'=>'Выручка',
                'contentOptions' =>['style'=>'color:black;'],
                'value'=>function ($model, $key, $index, $widget) {
                    return  $model->fact_oplata;
                },
                'width'=>'150px',
                /*                'hAlign'=>'right',*/
                'format'=>['decimal', 0],
            ],
        ],
    ]);;?>
