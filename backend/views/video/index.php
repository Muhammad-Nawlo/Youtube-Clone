<?php

use common\models\Video;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model common\models\Video */

$this->title = 'Videos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Video', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'Video',
                'content' => function ($model) {
                    return $this->render('video_item',['model'=>$model]);
                },

            ],
            'description:ntext',
            'created_at:dateTime',
            [
                'attribute' => 'status',
                'content' => function ($model) {
                    return $model->getListStatus()[$model->status];
                },
            ],
            'tags',
            [
                'class' => ActionColumn::className(),
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        return Html::a(Html::tag('i', '', [
                            'class' => 'bi bi-trash-fill',
                        ]), Url::to(['/video/delete', 'video_id' => $model->video_id]), [
                            'data-method' => 'POST',
                            'data-confirm' => 'Are you sure to delete this video'
                        ]);
                    },
                ]

            ],
        ],
    ]); ?>


</div>
