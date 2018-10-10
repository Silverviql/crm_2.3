<?php

namespace app\models;


class AnalyticsList extends \yii\db\ActiveRecord{

    public static function tableName()
    {
        return 'zakaz'; // Имя таблицы в БД в которой хранятся записи'
    }


    public static function getAll()
    {
        $data = self::find()->all();
        return $data;

    }

}