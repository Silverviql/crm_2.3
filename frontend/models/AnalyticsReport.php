<?php


namespace app\models;
use console\controllers\PusherController;
use yii\db\ActiveRecord;

class AnalyticsReport extends ActiveRecord
{


    public static function tableName()
    {
        return 'book';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'buy_amount'], 'required'],
            [['name', 'buy_amount'], 'safe'],
            [['buy_amount'], 'number', 'min'=>0, 'max'=>5000]
        ];
    }
    public function get () {
        $data = [
        'topic_id' => 'onNewData',
        'data'  => 'eventData' . rand(1,100)
    ];
    \console\components\Pusher::sentDataToServer($data);
    var_dump($data);
    }

}