<?php

namespace common\models;

use common\models\VideoView;
use Imagine\Image\Box;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;
use yii\imagine\Image;

/**
 * This is the model class for table "video".
 *
 * @property string $video_id
 * @property string|null $video_name
 * @property string|null $title
 * @property string|null $description
 * @property string|null $tags
 * @property int|null $status
 * @property int|null $has_thumbnail
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 *
 * @property User $createdBy
 */
class Video extends \yii\db\ActiveRecord
{
    const UNLISTED = 0;
    const PUBLISHED = 1;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => false
            ]
        ];
    }

    /**
     * @var UploadedFile
     */
    public $videoFile;

    public $thumbFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'video';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['videoFile'], 'file', 'extensions' => ['mp4']],
            [['thumbFile'], 'file', 'extensions' => 'jpg, png'],
            [['description'], 'string'],
            [['status', 'has_thumbnail', 'created_at', 'updated_at', 'created_by'], 'integer'],
            [['video_id'], 'string', 'max' => 10],
            [['video_name', 'title', 'tags'], 'string', 'max' => 512],
            [['video_id'], 'unique'],
            [['status'], 'default', 'value' => 0],
            [['has_thumbnail'], 'default', 'value' => 0],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'video_id' => 'Video ID',
            'video_name' => 'Video Name',
            'title' => 'Title',
            'description' => 'Description',
            'tags' => 'Tags',
            'status' => 'Status',
            'has_thumbnail' => 'Has Thumbnail',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'thumbnail' => 'Thumbnail',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\VideoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\VideoQuery(get_called_class());
    }

    public function getListStatus()
    {
        return [
            self::UNLISTED => 'Unlisted',
            self::PUBLISHED => 'Published'
        ];
    }

    public function getVideoLink()
    {
        return yii::$app->params['frontendUrl'] . '/storage/videos/' . $this->video_id . '.mp4';
    }

    public function getThumbnailLink()
    {
        return yii::$app->params['frontendUrl'] . '/storage/thumbnails/' . $this->video_id . '.png';
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->isNewRecord) {
            $this->video_id = Yii::$app->security->generateRandomString(10);
            $this->title = $this->videoFile->name;
            $this->video_name = $this->videoFile->name;
            $videoPath = Yii::getAlias('@frontend/web/storage/videos/' . $this->video_id . '.mp4');
            if (!is_dir(dirname($videoPath))) {
                FileHelper::createDirectory(dirname($videoPath));
            }
            $this->videoFile->saveAs($videoPath);
        }
        if ($this->thumbFile) {
            $this->has_thumbnail = 1;
        }
        if ($this->thumbFile) {
            $thumbnailPath = Yii::getAlias('@frontend/web/storage/thumbnails/' . $this->video_id . '.png');
            if (!is_dir(dirname($thumbnailPath))) {
                FileHelper::createDirectory(dirname($thumbnailPath));
            }
            $this->thumbFile->saveAs($thumbnailPath);
            Image::getImagine()->open($thumbnailPath)->thumbnail(new Box(1280, 1280))->save();
        }
        if (!parent::save($runValidation, $attributeNames))
            return false;
        return true;
    }

    public function afterDelete()
    {
        if (!parent::afterDelete())
            return false;
//Delete the video
        $videoPath = Yii::getAlias('@frontend/web/storage/videos/' . $this->video_id . '.mp4');
        if (file_exists($videoPath))
            unlink($videoPath);

//Delete the thumbnail of the video
        $thumbnailPath = Yii::getAlias('@frontend/web/storage/thumbnails/' . $this->video_id . '.png');
        if (file_exists($thumbnailPath))
            unlink($thumbnailPath);
        return true;
    }

    public function getViews()
    {
        return $this->hasMany(VideoView::className(), ['video_id' => 'video_id']);
    }

    public function getLikes()
    {
        return $this->hasMany(VideoLikeDislike::className(), ['video_id' => 'video_id']);
    }

    public function getDislikes()
    {
        return $this->hasMany(VideoLikeDislike::className(), ['video_id' => 'video_id']);
    }

    public function isLikedBy($user_id)
    {
        return VideoLikeDislike::findOne([
            'user_id' => $user_id,
            'video_id' =>$this->video_id,
            'type' => VideoLikeDislike::LIKE
        ]);
    }

    public function isDislikedBy($user_id)
    {
        return VideoLikeDislike::findOne([
            'user_id' => $user_id,
            'video_id' =>$this->video_id,
            'type' => VideoLikeDislike::DISLIKE
        ]);
    }

    public function getLikeCount()
    {
        return VideoLikeDislike::find()->where([
            'video_id' =>$this->video_id,
            'type' => VideoLikeDislike::LIKE
        ])->count();
    }

    public function getDislikeCount()
    {
        return VideoLikeDislike::find()->where([
            'video_id' =>$this->video_id,
            'type' => VideoLikeDislike::DISLIKE
        ])->count();
    }
}
