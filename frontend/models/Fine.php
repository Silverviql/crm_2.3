<?php

namespace app\models;

use app\models\query\FineQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "fine".
 *
 * @property integer $id
 * @property double $sum
 * @property integer $date
 * @property integer $category
 * @property integer $id_employee
 * @property string $comment
 *
 * @property Personnel $idEmployee
 */
class Fine extends \yii\db\ActiveRecord
{
    const FINE = 1;
    const BONUS = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fine';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sum', 'category', 'comment'], 'required'],
            [['category', 'id_employee'], 'integer'],
            [['date'], 'safe'],
            [['comment'], 'string'],
            ['sum', 'filter', 'filter' => function($value){
                return str_replace(' ', '', $value);
            }],
            [['id_employee'], 'exist', 'skipOnError' => true, 'targetClass' => Personnel::className(), 'targetAttribute' => ['id_employee' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sum' => 'Сумма',
            'date' => 'Date',
            'category' => 'Категория',
            'id_employee' => 'Сотрудник',
            'comment' => 'Комментарий',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEmployee()
    {
        return $this->hasOne(Personnel::className(), ['id' => 'id_employee']);
    }

    /**
     * @inheritdoc
     * @return FineQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FineQuery(get_called_class());
    }

    public static function getCattegoryArray()
    {
        return [
            self::FINE => 'Штраф',
            self::BONUS => 'Премия',
        ];
    }

    public function getCategoryName()
    {
        return ArrayHelper::getValue(self::getCattegoryArray(), $this->category);
    }
}
