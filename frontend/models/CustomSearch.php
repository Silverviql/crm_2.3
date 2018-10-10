<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Custom;

/**
 * CustomSearch represents the model behind the search form about `app\models\Custom`.
 */
class CustomSearch extends Custom
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'number'], 'integer'],
            [['tovar'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $index)
    {
        $query = Custom::find();
		if($index == 'zakup'){
			$query->where(['action' => 0]);
		} else {
            $query->where(['id_user' => Yii::$app->user->id]);
		}

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'date' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_user' => $this->id_user,
            'number' => $this->number,
        ]);

        $query->andFilterWhere(['like', 'tovar', $this->tovar]);

        return $dataProvider;
    }
}
