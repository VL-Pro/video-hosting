<?php

use yii\widgets\LinkPager;
use yii\helpers\Html;

/* @var $model \common\models\Topic */
/* @var $section \frontend\models\Section */
/* @var $pages \yii\data\Pagination */


$this->title = "Favorites";
$this->params['breadcrumbs'][] = $this->title;

?>

<div>
    <div class="row">
        <div class="col-lg-12">
            <h1><?= Html::encode($this->title) ?></h1>
            <p class="topic-description" ><?= $topic->description ?></p>
        </div>
    </div>


    <?php $i = 0; foreach ($models as $model): ?>
        <?php if($i % 3 == 0): ?>
            <div class="row">
        <?php endif; ?>
        <div class="col-md-4">
            <div class="video-item">
                <a href="/video/<?= $model->id ?>">
                    <div class="video-box">
                        <img src="<?= \common\models\Video::getParentFolderLink().$model->image->path ?>">
                    </div>
                    <span class="video-name"><?= $model->name ?></span>
                </a>
            </div>
            <div class="video-description">
                <?= $model->description ?>
            </div>
        </div>
        <?php $i++; if($i % 3 == 0): ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
    <?php if($i % 3 != 0)
        echo '</div>';
    ?>

    <div class="row">
        <div class="col-lg-12 text-center">
            <?= LinkPager::widget([
                'pagination' => $pages,
            ]);
            ?>
        </div>
    </div>
</div>
