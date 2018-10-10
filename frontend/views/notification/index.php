<?php

use app\models\Notification;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $countNew app\models\Notification */
/* @var $searchModel app\models\NotificationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Уведомление';
?>
<div class="notification-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Html::a('Отметить все прочитаным', ['ready', 'id' => Yii::$app->user->id])  ?>
    <br>
    <div class="notification-info" data-count="<?= $countNew ?>">
    <?php if ($countNew != 0): ?>
    <div class="notification-info_filter"><?= Html::a('Новый уведомление: '.$countNew, ['#'], ['id' => 'notification-new']) ?></div>
    <?php endif; ?>
    <?php foreach ($model as $notification): ?>
       <?php $date = date('Y-m-d H:i:s', time()) ?>
        <?php  echo Html::tag('p',Html::a($notification->name, ['open-notification', 'id' => $notification->id]),['style'=>$notification->active == Notification::ACTIVE ? 'font-weight: bold;':'']);
        ?>
    <?php endforeach ?>
    </div>
</div>
