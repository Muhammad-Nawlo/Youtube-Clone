<?php

namespace common\models\query;



use Yii;

/**
 * This is the ActiveQuery class for [[\common\models\Video]].
 *
 * @see \common\models\Video
 */
class VideoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\Video[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Video|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function creator()
    {
        return $this->andWhere(['created_by' => yii::$app->user->id]);
    }

    public function latest()
    {
        return $this->orderBy(['created_at'=>SORT_DESC]);

    }

}