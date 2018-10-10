<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\models\Tovar;
use app\models\Client;
use yii\db\ActiveRecord;
use yii\web\UploadeFile;

/**
 * This is the model class for table "zakaz".
 *
 * @property integer $id_zakaz
 * @property string $srok
 * @property integer $minut
 * @property integer $id_sotrud
 * @property string $sotrud_name
 * @property integer $prioritet
 * @property integer $status
 * @property integer $action
 * @property integer $id_tovar
 * @property integer $oplata
 * @property integer $fact_oplata
 * @property integer $number
 * @property string $data
 * @property string $description
 * @property string $information
 * @property string $img
 * @property string $maket
 * @property string $name
 * @property integer $phone
 * @property string $email
 * @property string $comment
 * @property integer $id_shipping
 *
 * @property Courier[] $couriers
 * @property Tovar $idTovar
 * @property User $idSotrud
 * @property Courier $idShipping
 */
class Zakaz extends ActiveRecord
{
    public $file;
    public $search;

    const STATUS_NEW = 0;
    const STATUS_EXECUTE = 1;
    const STATUS_ADOPTED = 2;
    const STATUS_DISAIN = 3;
    const STATUS_SUC_DISAIN = 4;
    const STATUS_REJECT = 5;
    const STATUS_MASTER = 6;
    const STATUS_SUC_MASTER = 7;
    const STATUS_AUTSORS = 8;

    const STATUS_DISAINER_NEW = 0;
    const STATUS_DISAINER_WORK = 1;
    const STATUS_DISAINER_SOGLAS = 2;

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
            [['srok', 'number', 'description', 'phone', 'sotrud_name'], 'required'],
            [['id_zakaz', 'id_tovar', 'oplata', 'fact_oplata', 'minut', 'number', 'status', 'action', 'id_sotrud', 'phone', 'id_shipping' ,'prioritet', 'statusDisain'], 'integer'],
            [['srok', 'data', 'data-start-disain'], 'safe'],
            [['information', 'comment', 'search'], 'string'],

            ['status', 'default', 'value' => self::STATUS_NEW],
            ['id_sotrud', 'default', 'value' => Yii::$app->user->getId()],
            ['data', 'default', 'value' => date('Y-m-d H:i:s')],

            [['description'], 'string', 'max' => 500],
            [['email', 'name', 'img', 'maket', 'sotrud_name'],'string', 'max' => 50],
            [['file'], 'file', 'skipOnEmpty' => true],
            [['id_sotrud'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_sotrud' => 'id']],
            [['id_tovar'], 'exist', 'skipOnError' => true, 'targetClass' => Tovar::className(), 'targetAttribute' => ['id_tovar' => 'id']],
            [['id_shipping'], 'exist', 'skipOnError' => true, 'targetClass' => Courier::className(), 'targetAttribute' => ['id_shipping' => 'id']],
            // [['id_client'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['id_client' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_zakaz' => '№',
            'srok' => 'Срок',
            'minut' => 'Часы',
            'id_sotrud' => 'Магазин',
            'sotrud_name' => 'Сотрудник',
            'prioritet' => 'Приоритет',
            'status' => 'Этап',
            'id_tovar' => 'Категория',
            'oplata' => 'Всего',
            'fact_oplata' => 'Оплачено',
            'number' => 'Количество',
            'data' => 'Дата принятия',
            'description' => 'Описание',
            'img' => 'Приложение',
            'maket' => 'Макет дизайнера',
            'statusDisain' => 'Этап',
            'data_start_disain' => 'Дата начала',
            'file' => 'Файл',
            'information' => 'Дополнительная информация',
            'name' => 'Клиент',
            'phone' => 'Телефон',
            'email' => 'Email',
            'comment' => 'Комментарий',
            'id_shipping' => 'Доставка',
            'search' => 'Search',
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
    public function getIdShipping()
    {
        return $this->hasOne(Courier::className(), ['id' => 'id_shipping']);
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
    public static function getStatusArray(){
        return [
            self::STATUS_NEW => 'Новый',
            self::STATUS_EXECUTE => 'Исполнен',
            self::STATUS_ADOPTED => 'Принят',
            self::STATUS_DISAIN => 'Дизайнер',
            self::STATUS_SUC_DISAIN => 'Дизайн готов',
            self::STATUS_REJECT => 'Отклонен',
            self::STATUS_MASTER => 'Мастер',
            self::STATUS_SUC_MASTER => 'Мастер сделал',
            self::STATUS_AUTSORS => 'Аутсорс',
        ];
    }
    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusArray(), $this->status);
    }
    public static function getPrioritetArray()
    {
        return [
            '0' => '',
            '1' => 'важно',
            '2' => 'очень важно',
        ];
    }
    public function getPrioritetName()
    {
        return ArrayHelper::getValue(self::getPrioritetArray(), $this->prioritet);
    }
    public static function getStatusDisainArray()
    {
        return [
            self::STATUS_DISAINER_NEW => 'Новый',
            self::STATUS_DISAINER_WORK => 'В работе',
            self::STATUS_DISAINER_SOGLAS => 'Согласование',
        ];
    }
    public function getStatusDisainName()
    {
        return ArrayHelper::getValue(self::getStatusDisainArray(), $this->statusDisain);
    }
    public function upload()
    {
        if($this->file){
        $this->file->saveAs('attachment/'.time().'.'.$this->file->extension);
        return true;
        } else {return false;}
    }
    public static function getPreficsList()
    {
        return [
            '2' => 'M',
            '6' => 'P',
            '8' => 'T',
            '9' => 'S',
        ];
    }

    public function getPrefics()
    {
        $list = self::getPreficsList();
        return (isset($list[$this->id_sotrud])) ? $list[$this->id_sotrud].'-'.$this->id_zakaz : $this->id_zakaz;
    }
}
