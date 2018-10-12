<?php

namespace app\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "personnel".
 *
 * @property integer $id
 * @property string $last_name
 * @property string $name
 * @property string $patronymic
 * @property string $nameSotrud
 * @property string $phone
 * @property string $store
 * @property integer $action
 * @property string $   job_duties
 * @property integer $shedule
 * @property string $password
 * @property integer $bonus
 * @property integer $email
 *
 * @property Financy[] $financies
 * @property PersonnelPosition[] $personnelPositions
 * @property Shifts[] $shifts
 */
class Personnel extends \yii\db\ActiveRecord
{
    const WORK = 0;
    const DISMISSAL = 1;

    const SHEDULE_DOUBLE = 1;
    const SHEDULE_WEEKdAYS = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'personnel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['last_name', 'name', 'phone','email'], 'required'],
            [['action', 'bonus', 'shedule'], 'integer'],
            [['last_name', 'name', 'patronymic', 'store','email'], 'string', 'max' => 50],
            [['job_duties', 'password'], 'string', 'max' => 86],
            [['phone'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'last_name' => 'Фамилия',
            'name' => 'Имя',
            'patronymic' => 'Отчество',
            'nameSotrud' => 'Фамилия и имя отчество',
            'phone' => 'Телефон',
            'email' => 'Почта',
            'store' => 'Магазин',
            'action' => 'Action',
            'job_duties' => 'Должностные обязанности',
            'shedule' => 'График работы',
            'password' => 'Код подтверждение',
            'positions' => 'Должность',
            'bonus' => 'Премия'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonnelPosition()
    {
        return $this->hasMany(PersonnelPosition::className(), ['personnel_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPositions()
    {
        return $this->hasMany(Position::className(), ['id' => 'position_id'])->via('personnelPosition');
    }

    /**
     * @return string
     */
    public function getNameSotrud()
    {
        return $this->last_name.' '.$this->name.' '.$this->patronymic;
    }

    /**
     * @return string
     */
    public function getPositionsAsString()
    {
        $arr = ArrayHelper::map($this->positions, 'id', 'name');
        return implode(', ', $arr);
    }

    /**
     * @return array
     */
    public static function getSheduleArray()
    {
        return [
            self::SHEDULE_DOUBLE => '2/2',
            self::SHEDULE_WEEKdAYS => '5/2'
        ];
    }

    public function getSheduleName()
    {
        return ArrayHelper::getValue(self::getSheduleArray(), $this->shedule);
    }

    public static function getSotrud()
    {
        return [
            ['Должность' => 'Директор', 'Имя' => 'Закиров Альберт Галиевич', 'Телефон' => '8(927)030-35-78', 'Магазин' => 'HQ', 'График работы' => '8:00-21:00', 'Вопросы' => 'Финансовые вопросы, стратегическое развитие и управление'],
            ['Должность' => 'Директор', 'Имя' => 'Закиев Дамир Валерьевич', 'Телефон' => '8(927)439-35-02', 'Магазин' => 'HQ', 'График работы' => '8:00-21:00', 'Вопросы' => 'Совершенствование бизнес-процессов, стратегическое развитие и управление'],
        ];
    }

    public static function getShop()
    {
        return [
            ['Название' => 'Штаб-квартира', 'Телефон' => '216-36-96', 'Адрес' => 'Островского 87', 'Почта' => 'holland.control.kzn@gmail.com'],
            ['Название' => 'Магазин', 'Телефон' => '8(903)314-73-92', 'Адрес' => 'Пушкина 5', 'Почта' => 'push5@holland-store.ru'],
            ['Название' => 'Магазин', 'Телефон' => '8(903)306-24-31', 'Адрес' => 'Сибирский тракт 16', 'Почта' => 'sib16@holland-store.ru'],
            ['Название' => 'Магазин', 'Телефон' => '8(927)043-50-89', 'Адрес' => 'Волгоградская 2Б', 'Почта' => 'volg2@holland-store.ru'],
            ['Название' => 'Магазин', 'Телефон' => '8(905)020-56-30', 'Адрес' => 'Четаева д.35', 'Почта' => 'chet@holland-store.ru'],
            ['Название' => 'Магазин', 'Телефон' => '8(965)622-54-24', 'Адрес' => 'Карла Маркса 59', 'Почта' => 'marx59@holland-store.ru'],
            ['Название' => 'Магазин', 'Телефон' => '8(967)367-74-99', 'Адрес' => 'Калинина 52', 'Почта' => 'kln52@holland-store.ru'],
        ];
    }
}
