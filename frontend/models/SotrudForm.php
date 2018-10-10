<?php
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Class SotrudForm
 * @package app\models
 */
class SotrudForm extends Model{
    public $sotrud;
    public $password;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['sotrud', 'password'], 'required'],
            ['password', 'validatePasswordSotrud'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'sotrud' => 'Сотрудник',
            'password' => 'Код подтверждение',
        ];
    }

    public function validatePasswordSotrud($attribute)
    {
        if (!$user = Personnel::findOne(['id' => $this->sotrud, 'password' => $this->password])){
            return $this->addError($attribute, 'Неправильный код подтверждение');
        }
    }

}