<?php

/* @var $this yii\web\View */
/* @var $model app\models\Cashbox */

$this->title = 'Отчет по кассе';
$this->params['breadcrumbs'][] = ['label' => 'Отчет по кассе', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partners-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
