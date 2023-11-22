<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[MsLevel]].
 *
 * @see MsLevel
 */
class MsLevelQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MsLevel[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MsLevel|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
