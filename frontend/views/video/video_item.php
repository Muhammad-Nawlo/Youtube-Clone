<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 4/15/2022
 * Time: 12:13 PM
 */

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/**
 * @var $model common\models\Video
 */
?>
<div class="card m-2">
    <a href="<?= Url::to(['/video/view/' . $model->video_id]) ?>">
        <div class="embed-responsive embed-responsive-16by9" style="width: 350px;height: 200px">
            <video class="embed-responsive-item" src="<?= $model->getVideoLink() ?>"
                   poster="<?= $model->getThumbnailLink() ?>"></video>
        </div>
    </a>
    <div class="card-body">
        <h5 class="card-title"><?= $model->title ?></h5>
        <p class="card-text my-0"><?= Html::a($model->createdBy->username,['/c/'.$model->createdBy->username],['class'=>'text-dark']) ?></p>
        <div>
            <span class="text-muted"> <?= $model->getViews()->count() ?> views</span> <span class="text-muted" style="font-weight: bolder">.</span>
            <span class="text-muted"><?= Yii::$app->formatter->asRelativeTime($model->created_at) ?></span>
        </div>
    </div>
</div>
