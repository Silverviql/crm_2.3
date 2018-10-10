<?php

namespace app\models;

use app\models\query\UserQuery;


/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $name
 * @property string #telegram_chat_id
 *
 * @property Zakaz[] $zakazs
 */
class User extends \yii\db\ActiveRecord
{
    const USER_PROGRAM = 1;
    const USER_MOSCOW = 2;
    const USER_MASTER = 3;
    const USER_DISAYNER = 4;
    const USER_ADMIN = 5;
    const USER_PUSHKIN = 6;
    const USER_COURIER = 7;
        const USER_SIBER = 9;
    const USER_ZAKUP = 10;
    const USER_SYSTEM = 11;
    const USER_CHETAEVA = 12;
    const USER_DAMIR = 13;
    const USER_ALBERT = 14;
    const USER_HR = 15;
    const USER_MARKX = 16;
    const USER_KALININA = 17;
    const USER_MANAGER = 18;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at', 'name'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['name', 'telegram_chat_id', 'token'], 'string', 'max' => 50],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'name' => 'Name',
            'telegram_chat_id' => 'Telegram Chat Id',
            'token' => 'Token',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZakazs()
    {
        return $this->hasMany(Zakaz::className(), ['id_sotrud' => 'id']);
    }
    
    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
}
