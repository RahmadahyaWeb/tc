<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TrPlafon]].
 *
 * @see TrPlafon
 */
class TrPlafonQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TrPlafon[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TrPlafon|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
