<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "cashbox".
 *
 * @property integer $id
 * @property string $date
 * @property string $name
 * @property string $surname
 * @property string $shop
 * @property integer $cash_on_cashbox
 * @property integer $cash_on_check
 * @property integer $non_cash
 * @property integer $payment_from_cashbox
 * @property string $to_which_payment
 * @property integer $refunds
 * @property integer $balance_in_cashbox
 * @property integer $attendance
 */
class Cashbox  extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cashbox';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['name', 'surname', 'shop', 'cash_on_cashbox', 'cash_on_check', 'non_cash', 'to_which_payment', 'refunds', 'balance_in_cashbox', 'attendance'], 'required'],
            [['cash_on_cashbox', 'cash_on_check', 'non_cash', 'payment_from_cashbox', 'refunds', 'balance_in_cashbox', 'attendance'], 'integer'],
            [['name', 'surname', 'shop'], 'string', 'max' => 50],
            [['to_which_payment'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Время отправки',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'shop' => 'Вы закрываете магазин:',
            'cash_on_cashbox' => 'Наличные деньги в кассе (руб.):',
            'cash_on_check' => 'Наличная выручка по чеку (руб.):',
            'non_cash' => 'Безналичная выручка по чеку (руб.):',
            'payment_from_cashbox' => 'Выплаты по чеку (руб.):',
            'to_which_payment' => 'Причина выплаты по чеку:',
            'refunds' => 'Возвраты: (руб.):',
            'balance_in_cashbox' => 'Остаток в кассе на завтрашнее утро (руб.):',
            'attendance' => 'Счетчик посещаемости',
        ];
    }
    public static function getAll()
    {
        $data = self::find()->all();
        return $data;
    }
}
