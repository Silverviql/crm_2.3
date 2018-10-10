<?php

use app\models\Position;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TodoistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Персонал';
?>

<p>
    <?= Html::a('Создать сотрудника', ['personnel/create'], ['class' => 'btn btn-success']) ?>
</p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'tableOptions' => ['class' => 'table table-bordered'],
    'showHeader' => true,
    'striped' => false,
    'hover' => true,
    'columns' => [
        [
            'attribute' => 'positions',
            'filter' => Position::find()->select(['name', 'id'])->indexBy('id')->column(),
            'value' => 'positionsAsString',
        ],
        [
            'attribute' => 'nameSotrud',
        ],
        [
            'attribute' => 'phone',
        ],
        [
            'attribute' => 'shedule',
            'value' => function($model){
                return $model->shedule != null ? $model->sheduleName : false;
            },
        ],
        [
            'attribute' => 'job_duties',
            'value' => function($model){
                return $model->job_duties != null ? $model->job_duties : false;
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Действие',
            'template' => '{view} {update} {link}',
            'buttons' => [
                'link' => function($url, $model, $key) {
                    return Html::a('Уволить', ['lay-off', 'id' => $model->id]);
                }
            ]
        ],
    ],
]) ?>
