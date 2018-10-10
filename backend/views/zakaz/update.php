<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Zakaz */

$this->title = 'Редактировать заказ: ' . $model->id_zakaz;
$this->params['breadcrumbs'][] = ['label' => 'Zakazs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_zakaz, 'url' => ['view', 'id' => $model->id_zakaz]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="zakaz-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
