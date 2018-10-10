<?php

namespace app\models\query;

use app\models\User;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\User]].
 *
 * @see \app\models\User
 */
class UserQuery extends ActiveQuery
{
     public function selectUser()
    {
        return $this->andWhere(['<>', 'id', User::USER_DISAYNER])
            ->andWhere(['<>', 'id', User::USER_MASTER])
            ->andWhere(['<>', 'id', User::USER_DAMIR])
            ->andWhere(['<>', 'id', User::USER_ALBERT])
            ->andWhere(['<>', 'id', User::USER_PROGRAM])
            ->andWhere(['<>', 'id', 8])
            ->andWhere(['<>', 'id', User::USER_COURIER])
            ->andWhere(['<>', 'id', User::USER_HR])
            ->andWhere(['<>', 'id', User::USER_ZAKUP])
            ->andWhere(['<>', 'id', User::USER_SYSTEM]);
    }
    public function selectUserAdm()
    {
        return $this->andWhere(['<>', 'id', User::USER_DISAYNER])
            ->andWhere(['<>', 'id', User::USER_MASTER])
            ->andWhere(['<>', 'id', User::USER_DAMIR])
            ->andWhere(['<>', 'id', User::USER_ALBERT])
            ->andWhere(['<>', 'id', User::USER_HR])
            ->andWhere(['<>', 'id', User::USER_ADMIN])
            ->andWhere(['<>', 'id', User::USER_PROGRAM])
            ->andWhere(['<>', 'id', 8])
            ->andWhere(['<>', 'id', User::USER_COURIER])
            ->andWhere(['<>', 'id', User::USER_ZAKUP])
            ->andWhere(['<>', 'id', User::USER_SYSTEM]);
    }


    public function todoistUser()
    {
        return $this->andWhere(['<>', 'id', User::USER_ALBERT])
            ->andWhere(['<>', 'id', User::USER_DAMIR])
            ->andWhere(['<>', 'id', User::USER_PROGRAM])
            ->andWhere(['<>', 'id', 8]);
    }

    public function todoistZakazUser()
    {
        return $this->andWhere(['<>', 'id', User::USER_PROGRAM])
            ->andWhere(['<>', 'id', User::USER_DAMIR])
            ->andWhere(['<>', 'id', User::USER_ALBERT]);
    }



    /**
     * @inheritdoc
     * @return \app\models\User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
