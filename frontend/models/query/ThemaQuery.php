<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[Thema]].
 *
 * @see Thema
 */
class ThemaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Thema[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Thema|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
