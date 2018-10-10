<?php

/* @var $this yii\web\View */
/* @var $model app\models\Todoist */

$this->title = 'Редактировать Задачу: ' . $model->id;
// $this->params['breadcrumbs'][] = ['label' => 'Todoists', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="todoist-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
