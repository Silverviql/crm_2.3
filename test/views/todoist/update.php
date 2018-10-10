<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Todoist */

$this->title = 'Update Todoist: ' . $model->id;
// $this->params['breadcrumbs'][] = ['label' => 'Todoists', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="todoist-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
