<?php
/**
 * @var $channel \common\models\User
 */

use yii\helpers\Url;

?>
<a class="btn <?= $channel->isSubscribed() ? 'btn-secondary' : 'btn-danger'; ?> btn-lg"
   href="<?= Url::to(['/channel/subscribe', 'channel_id' => $channel->id]) ?>" role="button" data-method="post"
   data-pjax="1">Subscribe <i class="bi bi-bell"></i> <span
            class="badge"><?= $channel->getSubscribers()->count(); ?></span></a>

