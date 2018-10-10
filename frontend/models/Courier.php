<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "courier".
 *
 * @property integer $id
 * @property integer $id_zakaz
 * @property string $date
 * @property string $to
 * @property string $data_to
 * @property string $from
 * @property string $data_from
 * @property string $commit
 * @property string $delivery_time
 *
 * @property Zakaz $idZakaz
 * @property Zakaz[] $zakazs
 */
class Courier extends \yii\db\ActiveRecord
{

    const DOSTAVKA = 0;
    const RECEIVE = 1;
    const DELIVERED = 2;
    const CANCEL = 3;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'courier';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['to', 'from', 'date'], 'required'],
            [['id_zakaz', 'status'], 'integer'],
            [['data_to', 'data_from', 'date', 'delivery_time'], 'safe'],
            [['commit'], 'string'],
            ['status', 'default', 'value' => 0],
            [['to', 'from'], 'string', 'max' => 50],
            [['id_zakaz'], 'exist', 'skipOnError' => true, 'targetClass' => Zakaz::className(), 'targetAttribute' => ['id_zakaz' => 'id_zakaz']],
        ];
    }
    public static function getStatusDostavka()
    {
        return [
            self::DOSTAVKA => 'Доставка',
            self::RECEIVE => 'Принято',
            self::DELIVERED => 'Доставлено',
        ];
    }
    public function getDostavkaName()
    {
        return ArrayHelper::getValue(self::getStatusDostavka(), $this->status);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_zakaz' => 'Заказ',
			'date' => 'Срок',
            'to' => 'Откуда',
            'data_to' => 'Data To',
            'from' => 'Куда',
            'data_from' => 'Data From',
            'status' => 'Доставка',
            'commit' => 'Доп. указания',
            'delivery_time' => 'Время доставки',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdZakaz()
    {
        return $this->hasOne(Zakaz::className(), ['id_zakaz' => 'id_zakaz']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZakazs()
    {
        return $this->hasMany(Zakaz::className(), ['id_shipping' => 'id']);
    }
    
    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->date = date('Y-m-d', strtotime($this->date));
        return parent::beforeSave($insert);
    }
}
