<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Zakaz]].
 *
 * @see Zakaz
 */
class ZakazQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Zakaz[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Zakaz|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
