<?php

use wdmg\widgets\TagsInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Video */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="video-form">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <div class="row">
        <div class="col-8">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
            <div class="form-group">
                <label for="thumbnailFile"><?= $model->getAttributeLabel('thumbnail') ?></label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="thumbnailFile" name="thumbnail">
                        <label class="custom-file-label" for="thumbnailFile">Choose file</label>
                    </div>
                </div>
            </div>
            <?= $form->field($model, 'tags')->widget(TagsInput::class, [
                'options' => [
                    'id' => 'post-tags',
                    'class' => 'form-control',
                    'placeholder' => 'Type your tags here...'

                ]
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <div class="col-4">
            <div class="embed-responsive embed-responsive-16by9 mb-2">
                <video class="embed-responsive-item" poster="<?= $model->getThumbnailLink() ?>"
                       src="<?= $model->getVideoLink() ?>" controls></video>
            </div>
            <div class="mb-2">
                <h3 class="text-muted">Video Link</h3>
                <a href="<?= $model->getVideoLink() ?>" target="_blank">Open Video</a>
            </div>
            <div class="mb-2">
                <h3 class="text-muted">Video Name</h3>
                <p><?= $model->video_name ?></p>
            </div>
            <div>
                <?= $form->field($model, 'status')->dropDownList($model->getListStatus()) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
