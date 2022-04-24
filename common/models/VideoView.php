<?php

namespace common\models;

use common\models\User;
use common\models\Video;
use Yii;

/**
 * This is the model class for table "video_view".
 *
 * @property int $id
 * @property string $video_id
 * @property int|null $user_id
 * @property int $created_at
 *
 * @property User $user
 * @property Video $video
 */
class VideoView extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'video_view';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['video_id', 'created_at'], 'required'],
            [['user_id', 'created_at'], 'integer'],
            [['video_id'], 'string', 'max' => 10],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['video_id'], 'exist', 'skipOnError' => true, 'targetClass' => Video::className(), 'targetAttribute' => ['video_id' => 'video_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'video_id' => 'Video ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Video]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVideo()
    {
        return $this->hasOne(Video::className(), ['video_id' => 'video_id']);
    }
}
