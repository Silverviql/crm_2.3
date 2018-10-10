<?php

namespace app\models;

use app\models\query\QuestionsQuery;
use app\models\Image;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%questions}}".
 *
 * @property int $id
 * @property string $name
 * @property string $answear
 * @property string $correct
 * @property int $active
 * @property int $id_theme
 *
 * @property Answers[] $answers
 * @property Thema $id0
 */
class Questions extends ActiveRecord
{
    const ACTIVE = 1;
    const NOT_ACTIVE = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%questions}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'answear', 'correct'], 'string'],
            [['id_theme', 'active'], 'integer'],
            ['active', 'default', 'value' => self::ACTIVE],
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
            'name' => 'Name',
            'answear' => 'Answear',
            'correct' => 'Correct',
            'active' => 'Active',
            'id_theme' => 'Id Theme',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answers::className(), ['id_question' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdThemeQuestion()
    {
        return $this->hasOne(Thema::className(), ['id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return QuestionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QuestionsQuery(get_called_class());
    }

    public function afterFind()
    {
        $this->answear = json_decode($this->answear, true);
        $this->correct = json_decode($this->correct, true);
    }

    public function upload($id)
    {
        $file = $_FILES['attachment'];
        $fileTempName = $file['tmp_name'];
        foreach ($fileTempName as $key => $tmp){
            $name = time().'-'.$key;
            if (is_uploaded_file($tmp)){
                if ($file['type'][$key] == 'image/png'){
                    $name .= '.png';
                } else if ($file['type'][$key] == 'image/jpg' || $file['type'][$key] == 'image/jpeg'){
                    $name .= '.jpg';
                }
                $newFilename = __DIR__.'../../web/images/'.$name;
                if (move_uploaded_file($tmp, $newFilename)){
                    $attachment = new Image();
                    $attachment->path = Yii::getAlias('@web').'/images/'.$name;
                    $attachment->id_question = $id;
                    $attachment->save();
                }
            } else {
                echo 'Файлы не загрузились на сереер';
            }
        }
    }
}
