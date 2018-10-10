<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "todoist".
 *
 * @property integer $id
 * @property string $date
 * @property string $srok
 * @property integer $id_zakaz
 * @property integer $id_user
 * @property integer $status
 * @property integer $typ
 * @property string $comment
 * @property integer $activate
 *
 * @property Zakaz $idZakaz
 */
class Todoist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'todoist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['srok', 'comment'], 'required'],
            [['srok', 'date'], 'safe'],
            [['id_zakaz', 'id_user', 'status', 'typ', 'activate'], 'integer'],
            [['comment'], 'string'],
            [['id_zakaz'], 'exist', 'skipOnError' => true, 'targetClass' => Zakaz::className(), 'targetAttribute' => ['id_zakaz' => 'id_zakaz']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Дата',
            'srok' => 'Срок',
            'id_zakaz' => 'Заказ',
            'id_user' => 'Назначение',
            'status' => 'Статус',
            'typ' => 'Тип',
            'comment' => 'Доп.указание',
            'activate' => 'Activate',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdZakaz()
    {
        return $this->hasOne(Zakaz::className(), ['id_zakaz' => 'id_zakaz']);
    }
}
