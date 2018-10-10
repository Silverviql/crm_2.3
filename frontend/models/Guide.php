<?php

namespace app\models;

/**
 * This is the model class for table "guide".
 *
 * @property integer $id
 * @property string $question
 * @property string $answer
 * @property string $standarts
 * @property string $title
 * @property string $attachment
 * @property integer $created_at
 * @property integer $updated_at
 */
class Guide extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'guide';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question', 'answer', 'standarts', 'title', 'created_at', 'updated_at'], 'required'],
            [['question', 'answer', 'standarts'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['title', 'attachment'], 'string', 'max' => 86],
            [['file'], 'file', 'skipOnEmpty' => true],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question' => 'Вопросы',
            'answer' => 'Ответы',
            'standarts' => 'Стандарты',
            'title' => 'Заголовок',
            'file' => 'Файл',
            'attachment' => 'Приложение',
            'created_at' => 'Создан',
            'updated_at' => 'Редактирован',
        ];
    }

    public function upload($action){
        $year = date('Y');
        $month = date('F');
        if (!is_dir('attachment/posts/' . $year)) {
            mkdir('attachment/posts/' . $year);
        }
        if (!is_dir('attachment/posts/' . $year . '/' . $month)) {
            mkdir('attachment/posts/' . $year . '/' . $month);
        }
        if ($action == 'create'){
            $this->file->saveAs('attachment/posts/'.$year.'/'.$month.'/'.date('Y-m-d H:i:s', time()).'.'.$this->file->extension);
            $this->attachment = 'attachment/posts/'.$year.'/'.$month.'/'.date('Y-m-d H:i:s', time()).'.'.$this->file->extension;
        } else {
            $this->file->saveAs('attachment/posts/'.$year.'/'.$month.'/'.$this->id.'.'.$this->file->extension);
            $this->attachment = 'attachment/posts/'.$year.'/'.$month.'/'.$this->id.'.'.$this->file->extension;
        }
    }
}
