<?php

use yii\widgets\LinkPager;
use yii\helpers\Html;

/* @var $model \common\models\Topic */
/* @var $section \frontend\models\Section */
/* @var $pages \yii\data\Pagination */


$this->title = $section->name;
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="section-view">
    <h1><?= Html::encode($this->title) ?></h1>
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
