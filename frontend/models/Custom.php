<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "custom".
 *
 * @property integer $id
 * @property integer $id_user
 * @property string $tovar
 * @property integer $number
 * @property string $date
 * @property integer $action
 * @property string $date_end
 *
 * @property User $idUser
 */
class Custom extends \yii\db\ActiveRecord
{
    const CUSTOM_NEW = 0;
    const CUSTOM_BROUGHT = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'custom';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tovar'], 'required'],
            [['id_user', 'number', 'action'], 'integer'],
            ['id_user', 'default', 'value' => Yii::$app->user->getId()],
            ['action', 'default', 'value' => 0],
            ['number', 'default', 'value' => 1],
            [['tovar'], 'string', 'max' => 50],
            [['date', 'date_end'], 'safe'],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Магазин',
            'tovar' => 'Товар',
            'number' => 'Кол-во',
            'date' => 'Дата',
            'action' => 'Статус',
            'date_end' => 'Date_end,',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
}
