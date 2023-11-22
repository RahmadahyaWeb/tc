<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[MsProvider]].
 *
 * @see MsProvider
 */
class MsProviderQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MsProvider[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MsProvider|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
