<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Todoist */

$this->title = 'Создать задачу';
// $this->params['breadcrumbs'][] = ['label' => 'Todoists', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="todoist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
