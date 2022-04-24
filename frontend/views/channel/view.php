<?php
/**
 * @var $this \yii\web\View
 */
/**
 * @var $channel \common\models\User
 *//**
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

use yii\widgets\LinkPager;
use yii\widgets\ListView;
use yii\widgets\Pjax;

?>
<div class="jumbotron">
    <h1 class="display-4"><?= $channel->username; ?> </h1>
    <hr class="my-4">
    <?php Pjax::begin([])?>
    <?= $this->render('subscribe_button',['channel'=>$channel])?>
    <?php Pjax::end()?>
</div>
<?=
ListView::widget([
'dataProvider'=>$dataProvider,
'pager'=>[
'class'=>LinkPager::className()
],
'itemView'=>'@frontend/views/video/video_item',
'layout'=>'<div class="d-flex flex-wrap">{items}</div>{pager}',
'itemOptions' => [
'tag' => false
]
]);
?>
