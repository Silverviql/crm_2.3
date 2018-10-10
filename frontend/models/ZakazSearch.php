<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


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
                $query->andWhere(['status' => [Zakaz::STATUS_MASTER, Zakaz::STATUS_DECLINED_MASTER], 'action' => 1]);
                $sort = ['srok' => SORT_ASC];
                break;
            case 'masterSoglas':
                $query->andWhere(['status' => Zakaz::STATUS_SUC_MASTER, 'action' => 1]);
                $sort = ['srok' => SORT_ASC];
                break;
            case 'disain':
                $query->andWhere(['status' => [Zakaz::STATUS_DISAIN,Zakaz::STATUS_DECLINED_DISAIN], 'statusDisain' => [Zakaz::STATUS_DISAINER_NEW, Zakaz::STATUS_DISAINER_WORK, Zakaz::STATUS_DISAINER_DECLINED], 'action' => 1]);
                $sort = ['srok' => SORT_ASC];
                break;
            case 'disainSoglas':
                $query->andWhere(['status' => Zakaz::STATUS_DISAIN, 'statusDisain' => Zakaz::STATUS_DISAINER_SOGLAS, 'action' => 1])
                ->orWhere(['status' => Zakaz::STATUS_SUC_DISAIN, 'action' => 1]);
                $sort = ['srok' => SORT_ASC];
                break;
            case 'shopWork':
                $query->andWhere(['id_shop' => Yii::$app->user->id, 'action' => 1, 'status' => [Zakaz::STATUS_DISAIN, Zakaz::STATUS_MASTER, Zakaz::STATUS_AUTSORS, Zakaz::STATUS_SUC_MASTER, Zakaz::STATUS_SUC_DISAIN, Zakaz::STATUS_DECLINED_DISAIN, Zakaz::STATUS_DECLINED_MASTER, Zakaz::STATUS_NEW, Zakaz::STATUS_ADOPTED]]);
                $sort = ['data' => SORT_DESC];
                break;
            case 'shopExecute':
                $query->andWhere(['id_shop' => Yii::$app->user->id, 'action' => 1, 'status' => Zakaz::STATUS_EXECUTE]);
                $sort = ['data' => SORT_DESC];
                break;
            case 'admin':
                $query->andWhere(['status' => [Zakaz::STATUS_DISAIN, Zakaz::STATUS_MASTER, Zakaz::STATUS_AUTSORS, Zakaz::STATUS_SUC_MASTER, Zakaz::STATUS_SUC_DISAIN, Zakaz::STATUS_DECLINED_DISAIN, Zakaz::STATUS_DECLINED_MASTER], 'action' => 1]);
             /*   $sort = ['status' => SORT_DESC];*/
                break;
            case 'adminWork':
                $query->andWhere(['status' => [Zakaz::STATUS_NEW, Zakaz::STATUS_ADOPTED, Zakaz::STATUS_REJECT], 'action' => 1]);
              /*  $sort = ['data' => SORT_DESC];*/
                break;
            case 'adminIspol':
                $query->andWhere(['status' => Zakaz::STATUS_EXECUTE, 'action' => 1]);
               /* $sort = ['srok' => SORT_DESC];*/
                break;  
            case 'archive':
                $query->andWhere(['action' => 0]);
                $sort = ['data' => SORT_DESC];
                break;
            case 'closeshop':
                $query->andWhere(['id_sotrud' => Yii::$app->user->id, 'action' => 0]);
                $sort = ['data' => SORT_DESC];
                break;
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => $sort,
            ],
        ]);

        // $dataProvider->pagination = false;

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
    
     public function searchmanager($params, $role, $id)
    {
        $query = Zakaz::find();

        switch ($role) {
            case 'shopWork':
                if (Yii::$app->user->id == User::USER_MANAGER) {
                    $query->andWhere(['id_shop' => $id, 'action' => 1, 'status' => [Zakaz::STATUS_DISAIN, Zakaz::STATUS_MASTER, Zakaz::STATUS_AUTSORS, Zakaz::STATUS_SUC_MASTER, Zakaz::STATUS_SUC_DISAIN, Zakaz::STATUS_DECLINED_DISAIN, Zakaz::STATUS_DECLINED_MASTER, Zakaz::STATUS_NEW, Zakaz::STATUS_ADOPTED]]);
                    $sort = ['data' => SORT_DESC];
                } else {
                    $query->andWhere(['id_shop' => Yii::$app->user->id, 'action' => 1, 'status' => [Zakaz::STATUS_DISAIN, Zakaz::STATUS_MASTER, Zakaz::STATUS_AUTSORS, Zakaz::STATUS_SUC_MASTER, Zakaz::STATUS_SUC_DISAIN, Zakaz::STATUS_DECLINED_DISAIN, Zakaz::STATUS_DECLINED_MASTER, Zakaz::STATUS_NEW, Zakaz::STATUS_ADOPTED]]);
                    $sort = ['data' => SORT_DESC];
                }
                break;
            case 'shopExecute':
                if (Yii::$app->user->id == User::USER_MANAGER) {
                    $query->andWhere(['id_shop' => $id, 'action' => 1, 'status' => [Zakaz::STATUS_DISAIN, Zakaz::STATUS_MASTER, Zakaz::STATUS_AUTSORS, Zakaz::STATUS_SUC_MASTER, Zakaz::STATUS_SUC_DISAIN, Zakaz::STATUS_DECLINED_DISAIN, Zakaz::STATUS_DECLINED_MASTER, Zakaz::STATUS_NEW, Zakaz::STATUS_ADOPTED]]);
                    $sort = ['data' => SORT_DESC];
                } else {
                    $query->andWhere(['id_shop' => Yii::$app->user->id, 'action' => 1, 'status' => Zakaz::STATUS_EXECUTE]);
                    $sort = ['data' => SORT_DESC];
                }

                break;
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => $sort,
            ],
        ]);

        // $dataProvider->pagination = false;

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
