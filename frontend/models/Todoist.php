<?php

namespace app\models;

use app\models\query\TodoistQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "todoist".
 *
 * @property integer $id
 * @property string $date
 * @property string $srok
 * @property integer $id_zakaz
 * @property integer $id_user
 * @property integer $id_sotrud_put
 * @property string $comment
 * @property string $img
 * @property string $declined
 * @property integer $activate
 *
 * @property Zakaz $idZakaz
 * @property User $idUser
 * @property User $idSotrudPut
 * @property mixed $upload
 */
class Todoist extends ActiveRecord
{
    public $file;

	const MOSCOW = 2;
	const PUSHKIN = 6;
	const SIBIR = 9;
	const ZAKUP = 10;

	const ACTIVE = 0;
	const CLOSE = 1;
	const COMPLETED = 2;
	const REJECT = 3;

	const SCENARIO_DEFAULT = 'default';
	const SCENARIO_DECLINED = 'declined';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'todoist';
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['srok', 'id_zakaz', 'comment', 'id_user' ,'id_sotrud_put', 'img','activate', 'declined'],
            self::SCENARIO_DECLINED => ['declined'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['srok', 'comment'], 'required', 'on' => self::SCENARIO_DEFAULT],
            [['declined'], 'required', 'on' => self::SCENARIO_DECLINED],
            [['srok', 'date'], 'safe'],
            [['id_zakaz', 'id_user', 'id_sotrud_put','activate'], 'integer'],
            [['comment', 'declined'], 'string'],
            [['img'], 'string', 'max' => 86],
            [['file'], 'file', 'skipOnEmpty' => true],
            [['id_sotrud_put'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_sotrud_put' => 'id']],
            [['id_zakaz'], 'exist', 'skipOnError' => true, 'targetClass' => Zakaz::className(), 'targetAttribute' => ['id_zakaz' => 'id_zakaz']],
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
            'date' => 'Дата',
            'srok' => 'Срок',
            'id_zakaz' => 'Заказ',
            'id_user' => 'Назначение',
            'id_sotrud_put' => 'Сотрудник поставил',
            'comment' => 'Доп.указание',
            'img' => 'Файл',
            'file' => 'Файл',
            'declined' => 'Отказ',
            'activate' => 'Статус',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdZakaz()
    {
        return $this->hasOne(Zakaz::className(), ['id_zakaz' => 'id_zakaz']);
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
    public function getIdSotrudPut()
    {
        return $this->hasOne(User::className(), ['id' => 'id_sotrud_put']);
    }

    /**
     * @inheritdoc
     * @return TodoistQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TodoistQuery(get_called_class());
    }

    public static function getIdUserArray()
	{
		return [
			self::MOSCOW => 'Московский',
			self::PUSHKIN => 'Пушкина',
			self::SIBIR => 'Сибирский',
			self::ZAKUP => 'Закупки',
		];
	}
	public function getIdUserName()
	{
		return ArrayHelper::getValue(self::getIdUser(), $this->id_user);
	}
    public static function getTodoistArray()
    {
        return [
            '0' => 'Активный',
            '1' => 'Выполнен',
        ];
    }

    /**
     * @return mixed
     */
    public function getTodoistName()
    {
        return ArrayHelper::getValue(self::getTodoistArray(), $this->activate);
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->srok = date('Y-m-d', strtotime($this->srok));
        return parent::beforeSave($insert);
    }

    public function upload()
    {
        $year = date('Y');
        $month = date('F');
        if (!is_dir('attachment/' . $year)) {
            mkdir('attachment/' . $year);
        }
        if (!is_dir('attachment/' . $year . '/' . $month)) {
            mkdir('attachment/' . $year . '/' . $month);
        }
        if (!is_dir('attachment/' . $year . '/' . $month.'/task')) {
            mkdir('attachment/' . $year . '/' . $month.'/task');
        }
        $this->file->saveAs('attachment/'.$year.'/'.$month.'/'.'task/'.time().'_todoist.'.$this->file->extension);
        $this->img = 'attachment/'.$year.'/'.$month.'/'.'task/'.time().'_todoist.'.$this->file->extension;
    }

}
