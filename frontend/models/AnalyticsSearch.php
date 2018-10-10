<?php

namespace app\models;


use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class AnalyticsSearch extends AnalyticsReport

{
    public $search;


    public static function tableName()
    {
        return 'book';
    }

    public function rules()
    {
        return [
            [['name', 'buy_amount', 'book_color'], 'required'],
            [['buy_amount', 'book_color'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    public function search()
    {
        $query = AnalyticsReport::find();



        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'buy_amount' => 'Buy Amount',
            'book_color' => 'AnalyticsReport Color',
        ];
    }

}

