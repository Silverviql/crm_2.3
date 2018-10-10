<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * HelpdeskSearch represents the model behind the search form about `app\models\Helpdesk`.
 */
class HelpdeskSearch extends Helpdesk
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'status'], 'integer'],
            [['commetnt', 'date', 'sotrud'], 'safe'],
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
    public function search($params, $status)
    {
        $query = Helpdesk::find();
        if (Yii::$app->user->can('system') && $status == 'work'){
            $query = $query->where(['status' => [Helpdesk::STATUS_NEW, Helpdesk::STATUS_DECLINED]]);
        } elseif(Yii::$app->user->can('system') && $status == 'soglas'){
            $query = $query->where(['status' => Helpdesk::STATUS_CHECKING]);
        } elseif(!Yii::$app->user->can('system') && $status == 'work') {
            $query = $query->where(['id_user' => Yii::$app->user->id, 'status' => [Helpdesk::STATUS_NEW, Helpdesk::STATUS_DECLINED]]);
        } else {
            $query = $query->where(['id_user' => Yii::$app->user->id, 'status' => Helpdesk::STATUS_CHECKING]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' =>
                    [
                        'date' => SORT_DESC,
                    ],
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
            'id_user' => $this->id_user,
            'status' => $this->status,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'commetnt', $this->commetnt])
            ->andFilterWhere(['like', 'sotrud', $this->sotrud]);

        return $dataProvider;
    }
}
