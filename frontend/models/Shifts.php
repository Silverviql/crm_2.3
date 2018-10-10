<?php

namespace app\models;

use app\models\query\ShiftsQuery;
use Yii;

/**
 * This is the model class for table "shifts".
 *
 * @property integer $id
 * @property string $start
 * @property string $end
 * @property integer $id_sotrud
 * @property integer $id_user
 * @property integer $number
 *
 * @property User $idUser
 * @property Personnel $idSotrud
 * @property Zakaz[] $zakazs
 */
class Shifts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shifts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['start', 'end'], 'safe'],
            [['id_sotrud', 'id_user', 'number'], 'integer'],
            ['id_user', 'default', 'value' => Yii::$app->user->id],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['id_sotrud'], 'exist', 'skipOnError' => true, 'targetClass' => Personnel::className(), 'targetAttribute' => ['id_sotrud' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'start' => 'Начало смены',
            'end' => 'End',
            'id_sotrud' => 'Id Sotrud',
            'id_user' => 'Id User',
            'number' => 'Number',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSotrud()
    {
        return $this->hasOne(Personnel::className(), ['id' => 'id_sotrud']);
    }

    /**
     * @inheritdoc
     * @return ShiftsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShiftsQuery(get_called_class());
    }
}
