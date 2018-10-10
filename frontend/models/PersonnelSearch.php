<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PersonnelSearch represents the model behind the search form about `app\models\Personnel`.
 */
class PersonnelSearch extends Personnel
{
    public $nameSotrud;
    public $positions;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'action'], 'integer'],
            [['last_name', 'name', 'nameSotrud', 'positions','phone'], 'safe'],
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
    public function search($params)
    {
        $query = Personnel::find()->with(['positions'])
            ->joinWith(['personnelPosition'], false)
            ->where(['action' => Personnel::WORK]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
           'attributes' => [
               'id' => [
                   'default' => SORT_ASC
               ],
//               'nameSotrud' => [
//                   'asc' => ['last_name' => SORT_ASC],
//                   'desc' => ['last_name' => SORT_DESC],
//               ],
//               'phone',
           ]
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
            'action' => $this->action,
            'personnel_position.position_id' => $this->positions,
        ]);

        $query->andFilterWhere(['like', 'last_name', $this->nameSotrud])
            ->orFilterWhere(['like', 'name', $this->nameSotrud])
            ->andFilterWhere(['like', 'phone', $this->phone]);

        return $dataProvider;
    }
}
