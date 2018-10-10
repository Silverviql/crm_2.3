<?php

/* @var $this yii\web\View */
/* @var $model app\models\Todoist */

$this->title = 'Задача к заказу '.Yii::$app->request->get('id_zakaz');
// $this->params['breadcrumbs'][] = ['label' => 'Todoists', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="todoist-create">

    <?= $this->render('_formzakaz', [
        'model' => $model,
    ]) ?>

</div>
