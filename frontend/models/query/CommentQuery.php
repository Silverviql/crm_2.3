<?php

namespace app\models\query;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Comment]].
 *
 * @see \app\models\Comment
 */
class CommentQuery extends ActiveQuery
{
    public function todoist($id)
    {
        return $this->select(['date', 'comment', 'id_user'])
            ->indexBy('id_todoist')
            ->with(['idUser'])
            ->where(['id_todoist' => $id])
            ->orderBy('id DESC')
            ->limit(3)
            ->all();
    }

    public function comment($id)
    {
        return $this->select(['date', 'comment', 'id_user'])
            ->indexBy('id_helpdesk')
            ->with(['idUser'])
            ->where(['id_helpdesk' => $id])
            ->orderBy('id DESC')
            ->limit(3)
            ->all();
    }

    public function zakaz($id)
    {
        return $this->with(['idUser'])
            ->where(['id_zakaz' => $id])
            // ->asArray()
            ->all();
    }

    /**
     * @inheritdoc
     * @return \app\models\Comment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Comment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
