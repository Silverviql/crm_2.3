<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model \app\models\User */
/* @var $position \app\models\Position */

$this->title = 'Картотека';
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать сотрудника', ['create'], ['class' => 'btn btn-success']) ?>
        <?php \yii\bootstrap\Modal::begin([
            'header' => 'Создать должность',
            'toggleButton' => [
                'tag' => 'button',
                'class' => 'btn btn-primary',
                'label' => 'Создать должность'
            ]
        ]);

        $form = \yii\widgets\ActiveForm::begin([
            'id' => 'user-create-position',
            'action' => ['create-position']
        ]);

        echo $form->field($position, 'name')->textInput();

        echo Html::submitButton('Создать', ['class' => 'tbn btn-primary']);

        \yii\widgets\ActiveForm::end();

        \yii\bootstrap\Modal::end(); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'username',
            [
                'attribute' => 'nameEmployee',
                'label' => 'ФИО'
            ],
            [
                'attribute' => 'date_birth',
                'format' => 'date',
            ],
            [
                'attribute' => 'id_position',
                'value' => function($value){
                    return $value->position->name;
                },
                'label' => 'Должность'
            ],
            [
                'attribute' => 'created_at',
                'format' => 'datetime',
                'label' => 'Дата приема'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
