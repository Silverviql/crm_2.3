<?php

namespace app\models;

use app\models\query\ImageQuery;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%image}}".
 *
 * @property int $id
 * @property string $path
 * @property int $id_question
 * @property string $create_At
 *
 * @property Questions $question
 */
class Image extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%image}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['path'], 'string'],
            [['id_question'], 'integer'],
            [['create_At'], 'safe'],
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
            'path' => 'Path',
            'id_question' => 'Id Question',
            'create_At' => 'Create  At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Questions::className(), ['id' => 'id_question']);
    }

    /**
     * @inheritdoc
     * @return ImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ImageQuery(get_called_class());
    }
}
