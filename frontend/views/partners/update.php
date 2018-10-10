<?php


/* @var $this yii\web\View */
/* @var $model app\models\Partners */

$this->title = 'Редактировать партнера: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Partners', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="partners-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
