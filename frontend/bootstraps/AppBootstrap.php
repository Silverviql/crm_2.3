<?php
namespace frontend\bootstraps;
use yii\base\BootstrapInterface;

 class AppBootstrap implements BootstrapInterface{

   public function bootstrap($app){
      $app->user->on(\common\models\User::EVENT_BEFORE_LOGIN,['common\models\User', 'beforeLogin']);
      $app->user->on(\common\models\User::EVENT_AFTER_LOGIN,['common\models\User', 'afterLogin']);
      $app->user->on(\common\models\User::EVENT_BEFORE_LOGOUT,['common\models\User', 'beforeLogout']);
   }
}
