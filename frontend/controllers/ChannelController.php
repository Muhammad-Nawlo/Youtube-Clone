<?php

namespace frontend\controllers;

use common\models\Subscribe;
use common\models\User;
use common\models\Video;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ChannelController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => AccessControl::class,
                'only' => ['subscribe'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
            [
                'class'=>VerbFilter::class,
                'actions'=>[
                    'subscribe'=>['post']
                ]
            ]
        ];
    }

    public function actionView($username)
    {
        $channel = User::findByUsername($username);
        if (!$channel) {
             throw new NotFoundHttpException('There is no a channel that has this name');
        }
        $dataProvider = new ActiveDataProvider([
            'query'=>Video::find()->where(['created_by'=>$channel->id])
        ]);
        return $this->render('view', [
            'channel' => $channel,
            'dataProvider'=>$dataProvider
        ]);
    }

    public function actionSubscribe($channel_id)
    {
        $user_id = Yii::$app->user->id;

        $isSubscribe = Subscribe::findOne(['user_id'=>$user_id,'channel_id'=>$channel_id]);
        if($isSubscribe){
            $isSubscribe->delete();
        }else{
            $newSubscriber = new Subscribe();
            $newSubscriber->channel_id = $channel_id;
            $newSubscriber->user_id = $user_id;
            $newSubscriber->created_at = time();
            $newSubscriber->save();
        }
        $channel = User::findOne(['id'=>$channel_id]);
        return $this->renderAjax('subscribe_button',['channel'=>$channel]);

    }

}