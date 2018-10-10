<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Nav;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TodoistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Задачник';
?>
<div class="todoist-index">

    <?php echo Nav::widget([
    'options' => ['class' => 'nav nav-pills'],
    'items' => [
    ['label' => 'Главная', 'url' => ['zakaz/index']],
    ['label' => 'Администратор', 'url' => ['zakaz/admin'], 'visible' => Yii::$app->user->can('seeAdmin')],
    ['label' => 'Дизайнер', 'url' => ['zakaz/disain'], 'visible' => Yii::$app->user->can('seeDisain')],
    ['label' => 'Мастер', 'url' => ['zakaz/master'], 'visible' => Yii::$app->user->can('master')],
    ['label' => 'Прием заказов', 'url' => ['zakaz/shop'], 'visible' => Yii::$app->user->can('seeShop')],
    ['label' => 'Закрытые заказы', 'url' => ['zakaz/archive'], 'visible' => Yii::$app->user->can('seeAdmin')],
    ['label' => 'Курьер', 'url' => ['courier/index'], 'visible' => Yii::$app->user->can('courier')],
    ['label' => 'Закрытые заказы', 'url' => ['zakaz/closezakaz'], 'visible' => Yii::$app->user->can('seeShop')],
    ['label' => 'Прочее', 'items' => [
        ['label' => 'Задачник', 'url' => ['todoist/index']],
        ['label' => 'Help Desk', 'url' => ['helpdesk/index']],
        ['label' => 'Запросы на товар', 'url' => ['custom/index']],
    ]],
    ],
]); ?>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php if (Yii::$app->user->can('admin')): ?>
            <?= Html::a('+', ['create_shop'], ['class' => 'btn btn-success']) ?>
        <?php endif ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'srok',
                'format' => ['date', 'php:d.m.Y'],
            ],
            // 'id_zakaz',
            'status',
            'typ',
            'id_user',
            'comment:ntext',
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
            ],


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
