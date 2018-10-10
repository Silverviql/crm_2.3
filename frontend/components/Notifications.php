<?php
/**
 * Created by PhpStorm.
 * User: holland
 * Date: 05.07.2017
 * Time: 14:15
 */
namespace frontend\components;

use yii\base\Widget;
use app\models\Notification;
use Yii;
use yii\helpers\Html;

class Notifications extends Widget
{
    public function run()
    {
        if (!Yii::$app->user->isGuest){
            $notifications = Notification::find()->where(['id_user' => Yii::$app->user->id, 'active' => 1])->all();
            echo '<div class="notification">';
                echo $notifications == null ? '<div class="notification-icon">' : '<div class="notification-icon newNotification">';
                    echo '<span class="glyphicon glyphicon-bell"></span>
                </div>
                <div class="notification-container hidden">
                <div class="notification-container_message">';
                foreach ($notifications as $notification){
                    echo '<div>'.Html::a($notification->name, ['notification/read-notice', 'id' => $notification->id], ['class' => 'notification-content']).'</div>';
                }
                echo '</div><div class="notification-all"><span>'.Html::a('Показать все', ['notification/index']).'</span></div>';
                echo '</div>
            </div>';
        }
    }
}