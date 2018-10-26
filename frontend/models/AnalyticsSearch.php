<?php

namespace app\models;


use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class AnalyticsSearch extends Zakaz

{
    public $search;
    public $date_from;
    public $date_to;


    public function rules()
    {
        return ArrayHelper::merge(
            [
                [['date_from','date_to'],'date', 'format' => 'php:d-m-Y'],
            ],
            parent::rules()
        );

    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    public function search()
    {
//        $query = Zakaz::find();
//
////      выборка по заказам за срок
//        $dataProvider = new ActiveDataProvider([
//            'query' => \app\models\Zakaz::find()
//                ->where('action <= 0') ->andWhere(['>=', 'date_close', '2018-09-01 00:00:00'])->andWhere(['<=', 'date_close','2018-10-01 00:00:00']),
//            'pagination' => [
//                'pageSize' => 10,
//            ],
//        ]);
//
//        return $dataProvider;
        $query = Zakaz::find();
        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query->where('action <= 0'),
            ]);

        $query->andFilterWhere(['>=','date_close', $this->date_from])
            ->andFilterWhere(['<=','date_close', $this->date_to]);
        return $dataProvider;
    }
}

