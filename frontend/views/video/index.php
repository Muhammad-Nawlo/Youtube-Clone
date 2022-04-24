<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 4/15/2022
 * Time: 12:13 PM
 */
/** @var $this \yii\web\View */
/** @var $dataProvider \yii\data\ActiveDataProvider */
use yii\bootstrap4\LinkPager;
use yii\widgets\ListView;

?>
<?=
ListView::widget([
    'dataProvider'=>$dataProvider,
    'pager'=>[
        'class'=>LinkPager::className()
    ],
    'itemView'=>'video_item',
    'layout'=>'<div class="d-flex flex-wrap">{items}</div>{pager}',
    'itemOptions' => [
        'tag' => false
    ]
])
?>
