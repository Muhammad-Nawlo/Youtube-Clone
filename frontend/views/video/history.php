<?php

/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

use yii\widgets\LinkPager;
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
