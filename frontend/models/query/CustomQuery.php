<?php

namespace app\models\query;

use app\models\Custom;

/**
 * This is the ActiveQuery class for [[\app\models\Custom]].
 *
 * @see \app\models\Custom
 */
class CustomQuery extends \yii\db\ActiveQuery
{
    public function manager()
    {
        return $this->andWhere(['<', 'date', date('Y-m-d H:i:s', strtotime('- 2 week'))])
            ->andWhere(['action' => Custom::CUSTOM_BROUGHT]);
    }

    /**
     * @inheritdoc
     * @return \app\models\Custom[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Custom|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
