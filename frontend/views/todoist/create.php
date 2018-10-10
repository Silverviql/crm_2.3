<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Todoist */

$this->title = 'Создать задачу';
// $this->params['breadcrumbs'][] = ['label' => 'Todoists', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="todoist-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
