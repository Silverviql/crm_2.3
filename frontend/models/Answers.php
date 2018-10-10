<?php

namespace app\models;

use app\models\query\AnswersQuery;
use Yii;

/**
 * This is the model class for table "{{%answers}}".
 *
 * @property int $id
 * @property string $text
 * @property int $id_question
 * @property int $id_thema
 * @property int $answer
 *
 * @property Questions $question
 * @property Choice[] $choices
 */
class Answers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%answers}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text', 'id_question', 'answer'], 'required'],
            [['id_question', 'answer', 'id_thema'], 'integer'],
            [['text'], 'string', 'max' => 255],
            [['id_question'], 'exist', 'skipOnError' => true, 'targetClass' => Questions::className(), 'targetAttribute' => ['id_question' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'id_question' => 'Id Question',
            'id_thema' => 'Id Thema',
            'answer' => 'Answer',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThema()
    {
        return $this->hasOne(Thema::className(), ['id' => 'id_thema']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Questions::className(), ['id' => 'id_question']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChoices()
    {
        return $this->hasMany(Choice::className(), ['id_answear' => 'id']);
    }

    /**
     * @inheritdoc
     * @return AnswersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AnswersQuery(get_called_class());
    }
}
