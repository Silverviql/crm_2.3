<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PartnersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Партнеры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partners-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'bordered' => false,
        'striped' => false,
        'pjax' => true,
        'pjaxSettings'=>[
            'neverTimeout'=>true,
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                'attribute' => 'street',
                'value' => function($model){
                    if($model->street == null){
                        return false;
                    } elseif ($model->room == null){
                        return $model->street;
                    } else {
                        return $model->street.' оф.'.$model->room;
                    }                }
            ],
            'phone',
            'whatsapp',
            'timetable',
            [
                'attribute' => 'contact_person',
                'filter' => false,
                'value' => function($model){
                    return $model->contact_person != null ? $model->contact_person : false;
                }
            ],
            [
                 'attribute' => 'email',
                 'filter' => false,
                 'format' => 'email',
                 'value' => function($model){
                    return $model->email != null ? $model->email : false;
                 }
            ],
            [
                 'attribute' => 'web',
                 'filter' => false,
                 'format' => 'raw',
                 'value' => function($model){
                        return $model->web != null ? Html::a($model->web, $model->web, ['target' => '_blank']) : false;
                },
            ],
            'specialization',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}'
            ],
        ],
    ]); ?>
</div>
