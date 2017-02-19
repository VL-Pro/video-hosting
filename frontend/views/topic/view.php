<?php

use yii\widgets\LinkPager;
use yii\helpers\Html;

/* @var $model \common\models\Topic */

$this->title = $topic->name;
$this->params['breadcrumbs'][] = ['label' => $section->name, 'url' => ['/section/view', 'id' => $section->id]];
$this->params['breadcrumbs'][] = $this->title;

?>



<div class="topic-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php foreach ($models as $model): ?>
        <div class="video-item">
            <h2><?= $model->name ?></h2>
            <p class="description"><?= $model->description ?></p>
            <p><a class="btn btn-default" href="/video/<?= $model->id ?>">View &raquo;</a></p>
        </div>
    <?php endforeach; ?>


    <?= LinkPager::widget([
        'pagination' => $pages,
    ]);
    ?>

</div>