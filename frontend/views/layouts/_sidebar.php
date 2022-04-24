<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 4/11/2022
 * Time: 2:53 AM
 */
use yii\bootstrap4\Nav;

?>
<aside class="shadow-sm">
    <?=
    Nav::widget([
        'options' => ['class' => 'd-flex flex-column nav-pills mt-1'],
        'items' => [
            ['label' => 'Home', 'url' => ['/video/index']],
            ['label' => 'History', 'url' => ['/video/history']]
        ]
    ]);
    ?>
</aside>
