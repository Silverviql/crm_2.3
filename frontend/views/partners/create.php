<?php

/* @var $this yii\web\View */
/* @var $model app\models\Partners */

$this->title = 'Создать партнера';
$this->params['breadcrumbs'][] = ['label' => 'Partners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partners-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
