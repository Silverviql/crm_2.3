<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Guide */

$this->title = 'Создение Guide';
$this->params['breadcrumbs'][] = ['label' => 'Guides', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="guide-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
