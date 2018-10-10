<?php

namespace app\models\query;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Shifts]].
 *
 * @see \app\models\Shifts
 */
class ShiftsQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    public function Shifts($id)
    {
        return $this->andWhere(['id_user' => $id])
            ->andWhere(['between', 'start', date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])
            ->andWhere(['end' => '0000-00-00 00:00:00']);
    }

    /**
     * @inheritdoc
     * @return \app\models\Shifts[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Shifts|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
