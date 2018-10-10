<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "otdel".
 *
 * @property integer $id
 * @property string $fio
 * @property string $otdel
 * @property string $thePost
 * @property integer $user_id
 *
 * @property User $user
 * @property Zakaz[] $zakazs
 */
class Otdel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'otdel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fio', 'otdel', 'thePost', 'user_id'], 'required'],
            [['id', 'user_id'], 'integer'],
            [['fio'], 'string', 'max' => 255],
            [['otdel', 'thePost'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'Fio',
            'otdel' => 'Otdel',
            'thePost' => 'The Post',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZakazs()
    {
        return $this->hasMany(Zakaz::className(), ['id_sotrud' => 'id']);
    }
}