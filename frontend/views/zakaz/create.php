<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Zakaz */


$this->title = 'Добавить заказ';
// $this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;

?>
<div class="zakaz-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
