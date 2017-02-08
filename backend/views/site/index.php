<?php

use yii\widgets\Menu;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>


<div class="site-index">

    <?php
        $menuItems = [
            ['label' => 'Sections', 'url' => ['/section/index']],
            ['label' => 'Topics', 'url' => ['/topic/index']],
            ['label' => 'Videos', 'url' => ['/video/index']],
            ['label' => 'Users', 'url' => ['/user/index']],
        ];

        echo Menu::widget([
            'options' => ['class' => 'list-group'],
            'items' => $menuItems,
            'linkTemplate' => '<a href="{url}" class="list-group-item"><span>{label}</span></a>',
        ]);
    ?>
</div>
