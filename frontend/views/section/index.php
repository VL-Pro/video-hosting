<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;


$this->title = "Sections";

?>

<div class="section-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="body-content">

        <?php $i = 0; foreach ($sections as $section): ?>
            <?php if($i % 3 == 0): ?>
                <div class="row">
            <?php endif; ?>
            <div class="col-md-4">
                <div class="section-desc text-center">
                    <h2><?= $section->name ?></h2>
                    <img width="250" height="250" src="<?=\common\models\Image::getImagesParentFolderLink().$section->image->path ?>">
                    <p><a class="btn btn-default" href="/section/<?= $section->id ?>">View &raquo;</a>
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
</div>