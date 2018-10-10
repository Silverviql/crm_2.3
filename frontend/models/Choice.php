<?php

namespace app\models;

use app\models\query\ChoiceQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%choice}}".
 *
 * @property int $id
 * @property int $id_user
 * @property string $answear
 * @property int $id_theme
 * @property int $result
 * @property string $date
 *
 * @property User $user
 * @property Thema $theme
 */
class Choice extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%choice}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'answear', 'id_theme'], 'required'],
            [['id_user', 'id_theme', 'result'], 'integer'],
            [['answear'], 'string'],
            [['date'], 'safe'],
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
            'answear' => 'Answear',
            'id_theme' => 'Id Theme',
            'result' => 'Result',
            'date' => 'Date',
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
     * @return ChoiceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ChoiceQuery(get_called_class());
    }

    public function afterFind()
    {
        $this->answear = json_decode($this->answear, true);
    }
}
