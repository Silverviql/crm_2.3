<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "cashbox".
 *
 * @property integer $id
 * @property string $date
 * @property string $name
 * @property string $shop
 * @property integer $cash_on_cashbox
 * @property integer $cash_on_check
 * @property integer $non_cash
 * @property integer $payment_from_cashbox
 * @property string $to_which_payment
 * @property integer $refunds
 * @property integer $balance_in_cashbox
 * @property integer $attendance
 * @property integer $boxberry_cash
 * @property integer $number_checks
 * @property  string $what_learned
 * @property  string $what_want_learn
 * @property  string $what_need_upgrade
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
            [['name', 'shop','what_learned','what_want_learn','what_need_upgrade'], 'required'],
            [['cash_on_cashbox', 'cash_on_check', 'non_cash', 'payment_from_cashbox', 'refunds', 'balance_in_cashbox', 'attendance', 'boxberry_cash', 'number_checks'], 'integer'],
            [['name', 'shop'], 'string', 'max' => 50],
            [['to_which_payment','what_learned','what_want_learn','what_need_upgrade'], 'string', 'max' => 255],
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
            'name' => 'ФИО',
            'shop' => 'Вы закрываете магазин:',
            'cash_on_cashbox' => 'Наличные деньги в кассе (руб.):',
            'cash_on_check' => 'Наличная выручка по чеку (руб.):',
            'non_cash' => 'Безналичная выручка по чеку (руб.):',
            'payment_from_cashbox' => 'Выплаты по чеку (руб.):',
            'to_which_payment' => 'Причина выплаты по чеку:',
            'refunds' => 'Возвраты: (руб.):',
            'balance_in_cashbox' => 'Остаток в кассе на завтрашнее утро (руб.):',
            'attendance' => 'Счетчик посещаемости',
            'boxberry_cash' => 'Оплата Boxberry',
            'number_checks' => 'Количество чеков',
            'what_learned' => 'Чему я сегодня научится',
            'what_want_learn' => 'Чему я хочу научиться ',
            'what_need_upgrade' => 'Что нужно улучшить в магазине',
        ];
    }
    public static function getAll()
    {
        $data = self::find()->all();
        return $data;
    }
}
