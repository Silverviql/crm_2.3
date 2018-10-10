<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Fine]].
 *
 * @see \app\models\Fine
 */
class FineQuery extends \yii\db\ActiveQuery
{
    public function payroll($id, $payroll)
    {
        return $this->where(['id_employee' => $id])
            ->andWhere(['>', 'date', $payroll]);
    }

    public function payrollCategory($id, $payroll, $category)
    {
        return $this->where(['id_employee' => $id, 'category' => $category])
            ->andWhere(['>', 'date', $payroll]);
    }

    /**
     * @inheritdoc
     * @return \app\models\Fine[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Fine|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
