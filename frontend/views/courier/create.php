<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Courier */

$this->title = 'Создать доставку';
//$this->params['breadcrumbs'][] = ['label' => 'Couriers', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="courier-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
