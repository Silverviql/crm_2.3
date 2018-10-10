<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Zakaz;


/**
 * ZakazSearch represents the model behind the search form about `app\models\Zakaz`.
 */
class ZakazSearch extends Zakaz
{
    public $search;
    // public $search;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_zakaz', 'id_sotrud', 'id_tovar', 'status'], 'integer'],
            [['srok', 'prioritet', 'data', 'name', 'email', 'phone', 'search', 'sotrud_name', 'description', 'information'], 'safe'],
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
    public function search($params, $role)
    {
        $query = Zakaz::find();

        switch ($role) {
            case 'master':
                $query->andWhere(['status' => Zakaz::STATUS_MASTER, 'action' => 1]);
                $sort = ['srok' => SORT_ASC];
                break;
            case 'disain':
                $query->andWhere(['status' => Zakaz::STATUS_DISAIN, 'action' => 1]);
                $sort = ['srok' => SORT_ASC];
                break;
            case 'shop':
                $query->andWhere(['id_sotrud' => Yii::$app->user->id, 'action' => 1]);
                $sort = ['data' => SORT_DESC];
                break;
            case 'admin':
                $query->andWhere(['status' => [Zakaz::STATUS_DISAIN, Zakaz::STATUS_MASTER, Zakaz::STATUS_AUTSORS], 'action' => 1]);
                $sort = ['srok' => SORT_DESC];
                break;
            case 'adminNew':
                $query->andWhere(['status' => Zakaz::STATUS_NEW, 'action' => 1]);
                $sort = ['srok' => SORT_DESC];
                break;
            case 'adminWork':
                $query->andWhere(['status' => [Zakaz::STATUS_ADOPTED, Zakaz::STATUS_REJECT, Zakaz::STATUS_SUC_MASTER, Zakaz::STATUS_SUC_DISAIN], 'action' => 1]);
                $sort = ['srok' => SORT_DESC];
                break;
            case 'adminIspol':
                $query->andWhere(['status' => Zakaz::STATUS_EXECUTE, 'action' => 1]);
                $sort = ['srok' => SORT_DESC];
                break;  
            case 'archive':
                $query->andWhere(['action' => 0]);
                break;
            case 'closeshop':
                $query->andWhere(['id_sotrud' => Yii::$app->user->id, 'action' => 0]);
                break;
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => $sort,
            ],
        ]);

        $dataProvider->pagination = false;

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_zakaz' => $this->id_zakaz,
            'srok' => $this->srok,
            'id_sotrud' => $this->id_sotrud,
            'id_tovar' => $this->id_tovar,
            'oplata' => $this->oplata,
            'data' => $this->data,
            // 'name' => $this->name,
            'email' => $this->email,
        ]);

        if (isset($this->search)) {
            $query->andFilterWhere(['like', 'sotrud_name', $this->search])
                ->orFilterWhere(['like', 'description', $this->search])
                ->orFilterWhere(['like', 'information', $this->search])
                ->orFilterWhere(['like', 'name', $this->search]);
        } else {
        $query->andFilterWhere(['like', 'prioritet', $this->prioritet])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email]);
        }

        return $dataProvider;
    }
    public function attributeLabels()
    {
        return [
            'srok' => 'Срок',
            'id_sotrud' => 'Магазин',
            'name' => 'Имя клиента',
            'status' => 'Этап',
            'phone' => 'Телефон',
            'data' => 'Дата принятия заказа',
            'search' => 'Поиск',
        ];
    }
}
