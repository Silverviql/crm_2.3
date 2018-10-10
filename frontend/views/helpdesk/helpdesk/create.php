<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Helpdesk */

$this->title = 'Создание запроса';
$this->params['breadcrumbs'][] = ['label' => 'Helpdesks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="helpdesk-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
