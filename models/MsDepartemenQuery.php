<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[MsDepartemen]].
 *
 * @see MsDepartemen
 */
class MsDepartemenQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MsDepartemen[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MsDepartemen|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
