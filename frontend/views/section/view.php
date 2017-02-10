<?php

use yii\widgets\LinkPager;

/* @var $model \common\models\Topic */

?>

<div class="section-view">
    <?php foreach ($models as $model): ?>
        <div class="topic-item">
            <h2><?= $model->name ?></h2>
            <p class="description"><?= $model->description ?></p>
            <p><a class="btn btn-default" href="/topic/<?= $model->id ?>">View &raquo;</a></p>
        </div>
    <?php endforeach; ?>


<?= LinkPager::widget([
            'pagination' => $pages,
    ]);
?>

</div>
