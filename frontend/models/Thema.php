<?php

namespace app\models;

use app\models\query\ThemaQuery;
use Yii;

/**
 * This is the model class for table "{{%thema}}".
 *
 * @property int $id
 * @property string $name
 * @property int $id_possition
 *
 * @property Access[] $accesses
 * @property Questions $questions
 * @property Testing[] $testings
 * @property Position $possition
 */
class Thema extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%thema}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['id_possition'], 'integer'],
            [['name'], 'string', 'max' => 200],
            ['id_possition', 'default', 'value' => 1],
            [['id_possition'], 'exist', 'skipOnError' => true, 'targetClass' => Position::className(), 'targetAttribute' => ['id_possition' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'id_possition' => 'Id Possition',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccesses()
    {
        return $this->hasMany(Access::className(), ['id_theme' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasOne(Questions::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestings()
    {
        return $this->hasMany(Testing::className(), ['id_theme' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPossition()
    {
        return $this->hasOne(Position::className(), ['id' => 'id_possition']);
    }

    /**
     * @inheritdoc
     * @return ThemaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ThemaQuery(get_called_class());
    }
}
