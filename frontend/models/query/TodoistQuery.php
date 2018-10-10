<?php

namespace app\models\query;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Todoist]].
 *
 * @see \app\models\Todoist
 */
class TodoistQuery extends ActiveQuery
{
//    public function active()
//    {
//        return $this->andWhere('[[status]]=1');
//    }

    public function getId($id)
    {
        return $this->indexBy('id')->with('idZakaz', 'idUser', 'idSotrudPut')->where(['id' => $id])->one();
    }

    /**
     * @inheritdoc
     * @return \app\models\Todoist[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Todoist|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
