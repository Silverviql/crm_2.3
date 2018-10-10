<?php

namespace app\models\query;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Financy]].
 *
 * @see \app\models\Financy
 */
class FinancyQuery extends ActiveQuery
{
    public function view($id)
    {
        return $this->select(['date', 'sum'])
            ->with('idUser', 'idZakaz')
            ->where(['id_zakaz' => $id])
            ->all();
    }

    /**
     * @inheritdoc
     * @return \app\models\Financy[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Financy|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
