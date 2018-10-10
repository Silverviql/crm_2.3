<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Zakaz */

$this->title = 'Заказ: ' . $model->id_zakaz;
//$this->params['breadcrumbs'][] = ['label' => 'Заказ', 'url' => ['admin']];
//$this->params['breadcrumbs'][] = ['label' => $model->id_zakaz, 'url' => ['admin', '#' => $model->id_zakaz]];
//$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="zakaz-update">

<!--    <h1>--><?//= Html::encode($this->title) ?><!--</h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
