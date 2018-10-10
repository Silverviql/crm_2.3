<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "partners".
 *
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property string $coordinate
 * @property string $city
 * @property string $street
 * @property string $room
 * @property string $phone
 * @property string $whatsapp
 * @property string $timetable
 * @property string $contact_person
 * @property string $email
 * @property string $web
 * @property string $specialization
 * @property integer $active
 *
 * @property Zakaz[] $zakazs
 */
class Partners extends ActiveRecord
{
    const ACTIVE = 0;
    const ClOSE = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'specialization','whatsapp', 'timetable'], 'required'],
            [['active'], 'integer'],
            [['name', 'coordinate', 'city', 'street', 'contact_person', 'email', 'web'], 'string', 'max' => 50],
            [['address', 'specialization'], 'string', 'max' => 86],
            [['phone', 'whatsapp', 'timetable'], 'string', 'max' => 15],
            [['room'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'address' => 'Адрес',
            'coordinate' => 'Координаты',
            'city' => 'Город',
            'street' => 'Улица',
            'room' => 'Кабинет',
            'phone' => 'Телефон',
            'whatsapp' => 'Whatsapp',
            'timetable' => 'График работы',
            'contact_person' => 'Контактное лицо',
            'email' => 'Email',
            'web' => 'Сайт',
            'specialization' => 'Специализация',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZakazs()
    {
        return $this->hasMany(Zakaz::className(), ['id_autsors' => 'id']);
    }
}
