<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 4/15/2022
 * Time: 12:12 PM
 */

namespace frontend\controllers;


use common\models\Video;
use common\models\VideoLikeDislike;
use common\models\VideoView;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use const http\Client\Curl\VERSIONS;

class VideoController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['like', 'dislike', 'history'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'like' => ['post'],
                    'dislike' => ['post'],
                ]
            ]


        ];
    }

    public $enableCsrfValidation = false;

    /**
     * Lists all Video models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Video::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'video_id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($video_id)
    {
        $this->layout = 'blank';
        $video = Video::findOne(['video_id' => $video_id]);
        $newView = new VideoView();
        $newView->video_id = $video->video_id;
        $newView->user_id = yii::$app->user->id ?: NULL;
        $newView->created_at = time();
        $newView->save();

        $keyword = $video->title . ' ' . $video->description . ' ' . $video->tags;
        $similarVideos = Video::find()->andWhere('MATCH(title,description,tags) AGAINST (:keyword)', ['keyword' => $keyword])->orderBy('MATCH(title,description,tags) AGAINST (:keyword) DESC')->all();
        return $this->render('view', ['model' => $video, 'similarVideos' => $similarVideos]);
    }

    public function actionLike($video_id)
    {
        $user_id = yii::$app->user->id;
        $likeDislike = VideoLikeDislike::findOne([
            'user_id' => $user_id,
            'video_id' => $video_id
        ]);
        if (!$likeDislike) {
            $this->likeDislike($video_id, $user_id, VideoLikeDislike::LIKE);
        } elseif ($likeDislike->type == VideoLikeDislike::LIKE) {
            $likeDislike->delete();
        } else {
            $likeDislike->delete();
            $this->likeDislike($video_id, $user_id, VideoLikeDislike::LIKE);
        }

        $model = Video::findOne(['video_id' => $video_id]);
        return $this->renderAjax('likeDislikeButtons', ['model' => $model]);
    }

    public function actionDislike($video_id)
    {
        $user_id = yii::$app->user->id;
        $likeDislike = VideoLikeDislike::findOne([
            'user_id' => $user_id,
            'video_id' => $video_id
        ]);
        if (!$likeDislike) {
            $this->likeDislike($video_id, $user_id, VideoLikeDislike::DISLIKE);
        } elseif ($likeDislike->type == VideoLikeDislike::DISLIKE) {
            $likeDislike->delete();
        } else {
            $likeDislike->delete();
            $this->likeDislike($video_id, $user_id, VideoLikeDislike::DISLIKE);
        }
        $model = Video::findOne(['video_id' => $video_id]);
        return $this->renderAjax('likeDislikeButtons', ['model' => $model]);
    }

    private function likeDislike($video_id, $userId, $type)
    {
        $newLike = new VideoLikeDislike();
        $newLike->video_id = $video_id;
        $newLike->user_id = $userId;
        $newLike->type = $type;
        $newLike->created_at = time();
        $newLike->save();
    }

    public function actionSearch($keyword)
    {
        $query = Video::find();

        if ($keyword) {
            $query->andWhere('MATCH(title,description,tags) AGAINST (:keyword)', ['keyword' => $keyword])->orderBy('MATCH(title,description,tags) AGAINST (:keyword) DESC');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);

    }

    public function actionHistory()
    {
        $query = Video::find()
            ->alias('v')
            ->innerJoin("(SELECT video_id, MAX(created_at) as max_date FROM video_view
                    WHERE user_id = :userId
                    GROUP BY video_id) vv", 'vv.video_id = v.video_id', [
                'userId' => \Yii::$app->user->id
            ])
            ->orderBy("vv.max_date DESC");

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        return $this->render('history', [
            'dataProvider' => $dataProvider
        ]);
    }

}