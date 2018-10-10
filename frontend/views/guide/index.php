<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\GuideSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Guides';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="guide-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать Guide', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title:ntext',
             [
                 'attribute' => 'created_at',
                 'value' => function($model){
                    return Yii::$app->formatter->asDatetime($model->created_at);
                 }
             ],
            [
                'attribute' => 'updated_at',
                'value' => function($model){
                    return Yii::$app->formatter->asDatetime($model->updated_at);
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {link}',
                'buttons' => [
                    'link' => function($url, $model, $key){
                        return Html::a('Показать', ['post', 'id' => $key]);
                    }
                ]
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
