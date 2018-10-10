<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TodoistSearch represents the model behind the search form about `app\models\Todoist`.
 */
class TodoistSearch extends Todoist
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_zakaz'], 'integer'],
            [['srok', 'comment'], 'safe'],
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
        $query = Todoist::find()->with(['idZakaz', 'idUser', 'idSotrudPut'])->indexBy('id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        switch ($index) {
            case 'close':
                $query = $query->where(['activate' => Todoist::CLOSE]);
                break;
            case 'admin-their':
                $query = $query->andWhere(['activate' => [Todoist::ACTIVE, Todoist::COMPLETED, Todoist::REJECT], 'id_sotrud_put' => Yii::$app->user->id]);
                break;
            case 'admin-alien':
                $query = $query->andWhere(['<>', 'id_sotrud_put', Yii::$app->user->id])
                                ->andWhere(['id_user' => Yii::$app->user->id])
                                ->andWhere(['activate' => [Todoist::ACTIVE, Todoist::COMPLETED, Todoist::REJECT ]]);
                break;
            case 'shop-their':
                $query = $query->andWhere(['<>', 'id_sotrud_put', User::USER_ADMIN])
                    ->andWhere(['id_sotrud_put' => Yii::$app->user->id, 'activate' => [Todoist::ACTIVE, Todoist::COMPLETED, Todoist::REJECT]]);
                break;
            case 'shop-alien':
                $query = $query->where(['id_user' => Yii::$app->user->id, 'activate' => [Todoist::ACTIVE, Todoist::COMPLETED, Todoist::REJECT]]);
                break;
            case 'overdue':
                $query = $query->andWhere(['<', 'srok', date('Y-m-d')])
                    ->andWhere(['activate' => !Todoist::CLOSE]);
        }

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'srok' => $this->srok,
            'id_zakaz' => $this->id_zakaz,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
