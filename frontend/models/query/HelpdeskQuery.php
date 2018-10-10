<?php

namespace app\models\query;
use app\models\Helpdesk;
use Yii;

/**
 * This is the ActiveQuery class for [[\app\models\Helpdesk]].
 *
 * @see \app\models\Helpdesk
 */
class HelpdeskQuery extends \yii\db\ActiveQuery
{
    public function workSystem()
    {
        return $this->where(['status' => [
            Helpdesk::STATUS_NEW,
            Helpdesk::STATUS_DECLINED
        ]]);
    }

    public function workNotSystem()
    {
        return $this->where(['id_user' => Yii::$app->user->id, 'status' => [
            Helpdesk::STATUS_NEW,
            Helpdesk::STATUS_DECLINED
        ]]);
    }

    public function overudue()
    {
        return $this->andWhere(['<', 'date', date('Y-m-d h:i:s', strtotime('-1 day'))])
            ->andWhere(['status' => !Helpdesk::STATUS_APPROVED]);
    }

    /**
     * @inheritdoc
     * @return \app\models\Helpdesk[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Helpdesk|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
