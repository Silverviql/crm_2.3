<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[Access]].
 *
 * @see Access
 */
class AccessQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Access[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Access|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
