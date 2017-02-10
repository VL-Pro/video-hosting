<?php
/* @var $this yii\web\View */
?>
<h1>section/index</h1>

<div class="section-index">

    <div class="body-content">

        <div class="row">
            <?php foreach ($sections as $section): ?>
                <div class="col-md-4">
                    <div class="section-desc text-center">
                        <h2><?= $section->name ?></h2>
                        <img width="250" height="250" src="<?=\common\models\Image::getImagesParentFolderLink().$section->image->path ?>">
                        <p><a class="btn btn-default" href="/section/<?= $section->id ?>">View &raquo;</a></p>
                    </div>
                </div>
            <?endforeach ?>
        </div>


    </div>
</div>