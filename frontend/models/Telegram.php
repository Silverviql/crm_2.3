<?php
namespace frontend\models;

use common\models\User;
use Yii;
use yii\db\Exception;

class Telegram
{
    public static function start($data){
        return self::login($data);
    }

    /**
     * @param $data
     * @return string
     */
    public static function login($data)
    {
        $token = $data['raw'];
        if ($token && $user = User::findOne(['token' => $token])) {
            /** @var $user \app\models\User */
            if ($user->telegram_chat_id) {
                return "Уважаемый $user->name, Вы уже авторизованы в системе. ";
            }
            $user->telegram_chat_id = $data['chat_id'];
            $user->save();
            return "Добро пожаловать, $user->name. Вы успешно авторизовались!";
        } else {
            return "Извините, не удалось найти данный токен!";
        }
    }

    /**
     * @param $id
     *
     */
    public function message($id, $message)
    {
        /** @var $user \app\models\User */
        $user = User::findOne($id);
        if ($user->telegram_chat_id != null){
            try {
                Yii::$app->bot->sendMessage($user->telegram_chat_id, $message);
            } catch (Exception $e) {
                $e->getMessage();
            }
        }
    }
}