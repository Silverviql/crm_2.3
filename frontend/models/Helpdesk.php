<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "helpdesk".
 *
 * @property integer $id
 * @property integer $id_user
 * @property string $commetnt
 * @property integer $status
 * @property string $date
 * @property string $sotrud
 * @property string $date_end
 * @property string $declined
 */
class Helpdesk extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_CHECKING = 1;
    const STATUS_APPROVED = 2;
    const STATUS_DECLINED = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'helpdesk';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['commetnt'], 'required'],
            [['id_user', 'status'], 'integer'],
            ['id_user', 'default', 'value' => Yii::$app->user->getId()],
            ['status', 'default', 'value' => 0],
            [['commetnt', 'declined'], 'string'],
            [['date', 'endDate'], 'safe'],
            [['sotrud'], 'string', 'max' => 50],
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
            'id_user' => 'Магазин',
            'commetnt' => 'Описание',
            'status' => 'Статсус',
            'date' => 'Дата',
            'sotrud' => 'Имя сотрудника',
            'dateEnd' => 'Date_end',
            'declined' => 'Отклонено',
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    public static function getStatusHelpArray()
    {
        return [
            self::STATUS_NEW => 'Новый',
            self::STATUS_CHECKING => 'На проверке',
            self::STATUS_APPROVED => 'Одобрено',
            self::STATUS_DECLINED => 'Отклонено',
        ];
    }
    public function getStatusHelpName()
    {
        return ArrayHelper::getValue(self::getStatusHelpArray(), $this->status);
    }
}
