<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\models\Tovar;
use app\models\Client;

/**
 * This is the model class for table "zakaz".
 *
 * @property integer $id_zakaz
 * @property string $srok
 * @property integer $id_sotrud
 * @property string $prioritet
 * @property string $status
 * @property integer $id_tovar
 * @property integer $oplata
 * @property integer $number
 * @property string $data
 * @property string $description
 * @property string $information
 * @property integer $id_client
 * @property string $comment
 *
 * @property Otdel $idSotrud
 * @property Tovar $idTovar
 * @property Client $idClient
 */
class Zakaz extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zakaz';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['srok', 'minut', 'id_sotrud', 'oplata', 'number', 'data', 'description','name', 'phone'], 'required'],
            [['id_zakaz', 'id_sotrud', 'id_tovar', 'oplata', 'number'], 'integer'],
            [['srok', 'minut', 'data'], 'safe'],
            [['comment'], 'string'],
            [['prioritet', 'status'], 'string', 'max' => 36],
            [['description', 'information'], 'string', 'max' => 500],
            [['img'],'string', 'max' => 50],
            [['id_sotrud'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_sotrud' => 'id']],
            [['id_tovar'], 'exist', 'skipOnError' => true, 'targetClass' => Tovar::className(), 'targetAttribute' => ['id_tovar' => 'id']],
            // [['id_client'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['id_client' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_zakaz' => '№ заказа',
            'srok' => 'Срок',
            'minut' => 'Время выполнение срока',
            'id_sotrud' => 'Магазин',
            'prioritet' => 'Приоритет',
            'status' => 'Статус',
            'id_tovar' => 'Товар',
            'oplata' => 'Сумма',
            'number' => 'Количество',
            'data' => 'Дата принятия',
            'description' => 'Описание',
            'img' => 'Изображение',
            'information' => 'Дополнительная информация',
            'name' => 'Клиент',
            'phone' => 'Телефон',
            'comment' => 'Комментарий',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSotrud()
    {
        return $this->hasOne(User::className(), ['id' => 'id_sotrud']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTovar()
    {
        return $this->hasOne(Tovar::className(), ['id' => 'id_tovar']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public static function getSotrudList()
    {
        $sotruds = Otdel::find()
        ->select(['otdel.id','otdel.fio'])
        ->join('JOIN','zakaz', 'zakaz.id_sotrud = otdel.id')
        ->all();

        return ArrayHelper::map($sotruds, 'id', 'fio');
    }
    public static function getTovarList()
    {
        $tovars = Tovar::find()
        ->select(['tovar.id','tovar.name'])
        ->join('JOIN','zakaz', 'zakaz.id_tovar = tovar.id')
        ->all();

        return ArrayHelper::map($tovars, 'id', 'name');
    }
    // public static function getClientList()
    // {
    //     $tovars = Client::find()
    //     ->select(['client.id','client.fio'])
    //     ->join('JOIN','zakaz', 'zakaz.id_client = client.id')
    //     ->all();

    //     return ArrayHelper::map($tovars, 'id', 'fio');
    // }
}
