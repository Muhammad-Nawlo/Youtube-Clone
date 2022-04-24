<?php
/**
 * @var $model \common\models\Video
 */

use yii\helpers\Url;

?>

<a class="btn <?= $model->isLikedBy(Yii::$app->user->id) ? 'btn-outline-primary' : 'btn-outline-secondary' ?>"
   href="<?= Url::to(['video/like', 'video_id' => $model->video_id]) ?>" data-method="POST" data-pjax="1">
    <i class="bi bi-hand-thumbs-up"></i>
    <span class="badge <?= $model->isLikedBy(Yii::$app->user->id) ? 'badge-primary' : 'badge-secondary' ?>"><?= $model->getLikeCount() ?></span>
</a>
<a class="btn <?= $model->isDislikedBy(Yii::$app->user->id) ? 'btn-outline-primary' : 'btn-outline-secondary' ?>"
   href="<?= Url::to(['video/dislike', 'video_id' => $model->video_id]) ?>" data-method="POST" data-pjax="1">
    <i class="bi bi-hand-thumbs-down"></i>
    <span class="badge <?= $model->isDislikedBy(Yii::$app->user->id) ? 'badge-primary' : 'badge-secondary' ?>"><?= $model->getDislikeCount() ?></span>
</a>
