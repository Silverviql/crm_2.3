<?php
use app\models\Todoist;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TodoistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<?php $this->title = 'Все задачи' ?>

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
            'class' => 'kartik\grid\ExpandRowColumn',
            'width' => '1px',
            'enableRowClick' => true,
            'expandOneOnly' => true,
            'expandIcon' => '<span class="glyphicon glyphicon-chevron-right"></span>',
            'collapseIcon' => '<span class="glyphicon glyphicon-chevron-down"></span>',
            'detailUrl' => Url::to(['todoist-detail']),
            'value' => function(){
                return GridView::ROW_COLLAPSED;
            },
            'contentOptions' => ['class' => 'border-left textTr', 'style' => 'border:none'],

        ],
        [
            'attribute' => 'srok',
            'format' => ['date', 'php:d M'],
            'hAlign' => GridView::ALIGN_RIGHT,
            'contentOptions' => ['class' => 'textTr tr90 srok'],
        ],
        [
            'attribute' => 'comment',
            'contentOptions'=>['style'=>'white-space: normal;'],
        ],
        [
            'attribute' => 'action',
            'format' => 'raw',
            'contentOptions'=>['class'=>'textTr tr180'],
            'value' => function($model){
                if ($model->activate == Todoist::COMPLETED){
                    return Html::a(Html::encode('Принять'), ['close', 'id' => $model->id], ['class' => 'accept']).' / '.Html::a(Html::encode('Отклонить'), ['#'], ['class' => 'declinedTodoist', 'value' => Url::to(['declined', 'id' => $model->id])]);
                } elseif ($model->activate == Todoist::REJECT){
                    return Html::tag('span', Html::encode('Отклонено'), [
                        'class' => 'declined'
                    ]);
                } elseif($model->id_user == Yii::$app->user->id) {
                    return Html::a(Html::encode('Принять'), ['close', 'id' => $model->id], ['class' => 'accept']);
                } else {
                    return false;
                }
            }
        ],
        [
            'attribute' => 'zakaz',
            'format' => 'raw',
            'value' => function($model){
                if ($model->id_zakaz != null) {
                    return Html::a($model->idZakaz->prefics, ['zakaz/view', 'id' => $model->id_zakaz]);
                }
                return '';
            },
            'label' => 'Заказ',
            'hAlign' => GridView::ALIGN_RIGHT,
            'contentOptions' => ['class' => 'textTr tr70'],
        ],
        [
            'attribute' => 'id_user',
            'value' => function($model){
                if ($model->id_user == null){
                    return '';
                } else {
                    return $model->idUser->name;
                }
            },
            'contentOptions' => ['class' => 'textTr tr100'],
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}{delete}',
            'buttons' => [
                'delete' => function($url, $model){
                    return Html::a('<span class="glyphicon glyphicon-remove"></span>', ['close', 'id' => $model->id]);
                }
            ],
            'contentOptions' => ['class' => 'border-right textTr'],
        ],
    ],
]); ?>
