<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%testing}}".
 *
 * @property int $id
 * @property int $id_user
 * @property int $id_theme
 * @property int $execute
 *
 * @property User $user
 * @property Thema $theme
 */
class Testing extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%testing}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_theme', 'execute'], 'required'],
            [['id_user', 'id_theme', 'execute'], 'integer'],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['id_theme'], 'exist', 'skipOnError' => true, 'targetClass' => Thema::className(), 'targetAttribute' => ['id_theme' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'id_theme' => 'Id Theme',
            'execute' => 'Execute',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTheme()
    {
        return $this->hasOne(Thema::className(), ['id' => 'id_theme']);
    }

    /**
     * @inheritdoc
     * @return TestingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TestingQuery(get_called_class());
    }
}
