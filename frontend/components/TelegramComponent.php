<?php

namespace frontend\components;

use SonkoDmitry\Yii\TelegramBot\Component;


class TelegramComponent extends Component
{
    public function sendMessage(
        $chatId,
        $text,
        $parseMode = null,
        $disablePreview = false,
        $replyToMessageId = null,
        $replyMarkup = null,
        $disableNotification = false
    )
    {
        return parent::sendMessage(
            $chatId,
            $text,
            $parseMode,
            $disablePreview,
            $replyToMessageId,
            $replyMarkup,
            $disableNotification
        );
    }
}