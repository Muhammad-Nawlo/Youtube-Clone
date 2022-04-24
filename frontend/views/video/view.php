<?php
/**
 * @var $model \common\models\Video
 */
/**
 * @var $similarVideos \common\models\Video
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>
<div class="row">
    <div class="col-8">
        <div>
            <div class="embed-responsive embed-responsive-16by9">
                <video class="embed-responsive-item" src="<?= $model->getVideoLink() ?>"
                       poster="<?= $model->getThumbnailLink() ?>" controls autoplay></video>
            </div>
            <div>
                <h5 class="mt-3 mb-0"><?= $model->title ?></h5>
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted"> <?= $model->getViews()->count() ?> views</span> <span
                                style="font-weight: bolder">.</span>
                        <span class="text-muted">
                            <?= Yii::$app->formatter->asDate($model->created_at) ?>
                        </span>
                    </div>
                    <div>
                        <?php Pjax::begin([]) ?>
                        <?= $this->render('likeDislikeButtons', ['model' => $model]) ?>
                        <?php Pjax::end() ?>
                    </div>
                </div>
                <div>
                    <p class="card-text  mb-3"><?= Html::a($model->createdBy->username, ['/c/' . $model->createdBy->username], ['class' => 'text-dark']) ?></p>
              <p><?= $model->description?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="d-flex flex-column">
            <?php foreach ($similarVideos as $similarVideo):?>
            <a href="<?= Url::to(['/video/view/' . $similarVideo->video_id]) ?>" style="text-decoration: none;color: #000;"
               class="my-2">
                <div class="d-flex  align-items-center">
                    <div class="embed-responsive embed-responsive-16by9" style="width: 150px">
                        <video class="embed-responsive-item" src="<?= $similarVideo->getVideoLink() ?>"
                               poster="<?= $similarVideo->getThumbnailLink() ?>"></video>
                    </div>
                    <div class="d-flex flex-column">
                        <h5 class="card-title m-0"><?= $similarVideo->title ?></h5>
                        <p class="card-text my-0"><?= Html::a($similarVideo->createdBy->username,['/c/'.$similarVideo->createdBy->username],['class'=>'text-dark']) ?></p>
                        <small class="text-muted">
                            <span> 49K views</span> .
                            <span>
                            <?= Yii::$app->formatter->asDate($similarVideo->created_at) ?>
                        </span>
                        </small>
                    </div>
                </div>
            </a>
            <?php endforeach;?>
        </div>
    </div>
</div>
