<?php
use kartik\grid\GridView;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CustomSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Все запросы';
?>

<div class="custom-index">

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
                'attribute' => 'date',
                'format' => ['datetime', 'php:d M H:m'],
                'hAlign' => GridView::ALIGN_RIGHT,
                'contentOptions' => ['class' => 'border-left textTr tr90', 'style' => 'border:none'],
            ],
            [
                'attribute' => 'tovar',
                'contentOptions'=>['style'=>'white-space: normal;'],
            ],
            [
                'attribute' => 'number',
                'hAlign' => GridView::ALIGN_RIGHT,
                'contentOptions'=>['class' => 'textTr tr20'],
            ],
            [
                'attribute' => 'id_user',
                'hAlign' => GridView::ALIGN_RIGHT,
                'contentOptions'=>['class' => 'textTr tr20'],
                'value' => function($model){
                    return $model->idUser->name;
                }
            ],
            [
                'attribute' => '',
                'format' => 'raw',
                'contentOptions'=>['class' => 'border-right textTr tr50'],
                'value' => function($model) {
                    if(Yii::$app->user->can('zakup')){

                        return $model->action == 0 ? Html::a('Отправить', ['custom/close', 'id' => $model->id]) : '';
                    } else {
                        return false;
                    }
                },
            ],
        ],
    ]); ?>
</div>