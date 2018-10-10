<?php

use app\models\Helpdesk;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HelpdeskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<?php $this->title = 'Все поломки' ?>

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
            'attribute' => 'id',
            'hAlign' => GridView::ALIGN_RIGHT,
            'contentOptions' => ['class' => 'border-left textTr tr50', 'style' => 'border:none'],
        ],
        [
            'attribute' => 'date',
            'format' => ['date', 'php:d M H:i'],
            'hAlign' => GridView::ALIGN_RIGHT,
            'contentOptions' => ['class' => 'textTr tr90'],
        ],
        [
            'attribute' => 'commetnt',
            'format' => 'text',
            'contentOptions'=>['style'=>'white-space: normal;'],
        ],
        [
            'attribute' => 'id_user',
            'value' => 'idUser.name',
            'contentOptions' => ['class' => 'textTr tr90'],
            'hAlign' => GridView::ALIGN_RIGHT,
            'visible' => Yii::$app->user->can('system'),
        ],
        [
            'attribute' => 'sotrud',
            'contentOptions' => ['class' => 'textTr tr50'],
        ],
        [
            'attribute' => 'statusHelpName',
            'format' => 'raw',
            'contentOptions' => function($model){
                if ($model->status == Helpdesk::STATUS_CHECKING){
                    return Yii::$app->user->can('system') ? ['class' => 'textTr successHelp tr90'] : ['class' => 'border-right successHelp textTr'];
                } else {
                    return Yii::$app->user->can('system') ? ['class' => 'textTr tr90'] : ['class' => 'border-right textTr'];
                }
            },
            'hAlign' => GridView::ALIGN_LEFT,
            'value' => function($model){
                if ($model->status == Helpdesk::STATUS_DECLINED){
                    return Html::tag('span', Html::encode($model->statusHelpName), [
                        'title' => $model->declined,
                        'data-toggle' => 'popover',
                        'data-placement' => 'top',
                        'class' => 'declined',
                    ]);
                } else {
                    return $model->statusHelpName;
                }
            }
        ],
        [
            'attribute' => '',
            'format' => 'raw',
            'contentOptions' => ['class' => 'border-right textTr'],
            'value' => function($model) {
                if($model->status == Helpdesk::STATUS_NEW or $model->status == Helpdesk::STATUS_DECLINED){
                    return Html::a('Решена', ['helpdesk/close', 'id' => $model->id]);
                } else {
                    return '';
                }
            },
            'visible' => Yii::$app->user->can('system')
        ],
    ],
]); ?>
