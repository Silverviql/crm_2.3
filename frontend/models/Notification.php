<?php

namespace app\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "notification".
 *
 * @property integer $id
 * @property integer $id_user
 * @property string $name
 * @property integer $id_zakaz
 * @property integer $category
 * @property string $srok
 * @property integer $active
 *
 * @property Zakaz $idZakaz
 * @property User $idUser
 */
class Notification extends \yii\db\ActiveRecord
{
    const ACTIVE = 1;
    const NOT_ACTIVE = 0;

    const CATEGORY_SHIPPING = 0;
    const CATEGORY_SUCCESS = 1;
    const CATEGORY_NEW = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'category','active'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['srok'], 'safe'],
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
            'id_user' => 'Id User',
            'name' => 'Name',
            'id_zakaz' => 'Id Zakaz',
            'category' => 'Category',
            'srok' => 'Напоминание',
            'active' => 'Active',
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
    public function getSaveNotification()
    {
		$this->srok = null;
        $this->active = true;
        $this->save();
    }
    public static function getCategoryArray()
    {
        return [
            self::CATEGORY_SHIPPING => 'Доставка',
            self::CATEGORY_SUCCESS => 'Выполнена работа',
            self::CATEGORY_NEW => 'Новый заказ',
        ];
    }
    public function getCategoryName()
    {
        return ArrayHelper::getValue(self::getCategoryArray(), $this->category);
    }
    public function getByIdNotification($id, $zakaz)
    {
        switch ($id) {
            case '7'://оформление уведомление доставки
                $this->id_user = $id;
                $this->name = 'Новая доставка №'.$zakaz;
                $this->id_zakaz = $zakaz;
                $this->category = 2;
                break;
            case '4'://оформление уведомление дизайнеру
                $this->id_user = $id;
                $this->name = 'Новый заказ №'.$zakaz;
                $this->id_zakaz = $zakaz;
                $this->category = 2;
                break;
            case '3'://оформление уведомление мастеру
                $this->id_user = $id;
                $this->name = 'Новый заказ №'.$zakaz;
                $this->id_zakaz = $zakaz;
                $this->category = 2;
                break;
            case '8'://Уведомление, что мастер выполнил работу
                $this->id_user = 5;
                $this->name = 'Мастер выполнил работу №'.$zakaz;
                $this->id_zakaz = $zakaz;
                $this->category = 1;
                break;
            case '5'://оформление уведомление выполение работы дизайнера
                $this->id_user = $id;
                $this->name = 'Дизайнер выполнил работу №'.$zakaz;
                $this->id_zakaz = $zakaz;
                $this->category = 1;
                break;
        }
    }
    public function getReminder($id)
    {
        $this->id_user = 5;
        $this->name = 'Создана напоминание';
        $this->id_zakaz = $id;
        $this->category = 4;
        $this->active = true;
    }

    public function getCreateNotice($user, $order_id)
    {
        $this->id_user = $user;
        $this->name = 'Были правки в заказе '.$order_id;
        $this->active = self::ACTIVE;
        $this->id_zakaz = $order_id;
    }
}
