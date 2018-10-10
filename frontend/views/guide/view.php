<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Guide */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Guides', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="guide-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title:ntext',
            'question:ntext',
            'answer:ntext',
            'standarts:ntext',
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
        ],
    ]) ?>

    <p><?php echo $model->title ?></p>
    <p><?php echo $model->question ?></p>
    <p><?php echo $model->answer ?></p>

</div>
