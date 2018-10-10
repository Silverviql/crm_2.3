<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[Questions]].
 *
 * @see Questions
 */
class QuestionsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Questions[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Questions|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
