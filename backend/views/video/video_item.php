<?php
/**
 * @var $model common\models\Video
 */
use yii\helpers\StringHelper;
use yii\helpers\Url;

?>

<a href="<?= Url::to(['/video/update/' . $model->video_id]) ?>" style="text-decoration: none;color: #000;">
    <div class="d-flex  align-items-center">
        <div class="embed-responsive embed-responsive-16by9" style="width: 150px">
            <video class="embed-responsive-item" src="<?= $model->getVideoLink() ?>"
                   poster="<?= $model->getThumbnailLink() ?>"></video>
        </div>
        <h5 class="card-title"><?= $model->title ?></h5>
    </div>
</a>

