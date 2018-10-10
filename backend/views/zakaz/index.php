<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Otdel;
use app\models\Zakaz;
use dosamigos\datepicker\DatePicker;
use yii\bootstrap\Nav;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ZakazSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sidebar">
        <ui class="nav nav-pills">
            <li>
                <a href="index.php?r=zakaz%2Findex" >
                    <span>Заказ</span>
                </a>
            </li>
            <li>
                <a href="index.php?r=client%2Findex">
                    <span>Клиент</span>
                </a>
            </li>
            <?php if (!Yii::$app->user->isGuest && Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId())['admin']->name == 'admin') { ?>
            <li>
                <a href="index.php?r=tovar%2Findex">
                    <span>Товар</span>
                </a>
            </li>
            <?php } ?>
        </ui>
</div>
<div class="zakaz-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать заказ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_zakaz',
             [
                'attribute' => 'srok',
                'format' => ['datetime', 'php:d.m.Y'],
                'value' => 'srok',
                'filter' => DatePicker::widget([
                     'model' => $searchModel,
                     'attribute' => 'srok',
                    // inline too, not bad
                     'inline' => false, 
                     // modify template for custom rendering
                    // 'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
                    'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy.mm.dd'
                ],
                ]),
            ],
            [
                'attribute' => 'minut',
                'format' => ['datetime', 'php:H:i']
            ],
            // [
            //     'attribute' => 'id_sotrud',
            //     'value' => 'idSotrud.fio',
            //     'filter' => Zakaz::getSotrudList(),
            // ],
            'prioritet',
            'status',
            [
                'attribute' => 'id_tovar',
                'value' => 'idTovar.name',
                'filter' => Zakaz::getTovarList(),
            ],
            [
                'attribute'=>'oplata',
            ],
            // 'number',
            [
                'attribute'=>'data',
                'format'=>['date', 'php:d.m.Y']
            ],
            // 'description',
            // 'information',
            // 'img',
            [
                'attribute' => 'name',
            ],
            [
                'attribute' => 'phone',
            ],
            // 'comment:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
