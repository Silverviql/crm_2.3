<?php

namespace app\models;


/**
 * This is the model class for table "personnel_position".
 *
 * @property integer $personnel_id
 * @property integer $position_id
 *
 * @property Position $position
 * @property Personnel $personnel
 */
class PersonnelPosition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'personnel_position';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['personnel_id', 'position_id'], 'required'],
            [['personnel_id', 'position_id'], 'integer'],
            [['position_id'], 'exist', 'skipOnError' => true, 'targetClass' => Position::className(), 'targetAttribute' => ['position_id' => 'id']],
            [['personnel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Personnel::className(), 'targetAttribute' => ['personnel_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'personnel_id' => 'Personnel ID',
            'position_id' => 'Position ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosition()
    {
        return $this->hasOne(Position::className(), ['id' => 'position_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonnel()
    {
        return $this->hasOne(Personnel::className(), ['id' => 'personnel_id']);
    }
}
