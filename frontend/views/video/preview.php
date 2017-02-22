<?php
/* @var $this yii\web\View */

use yii\helpers\Html;


$this->title = $model->name.' (Preview)';
$this->params['breadcrumbs'][] = ['label' => $section->name, 'url' => ['/section/view', 'id' => $section->id]];
$this->params['breadcrumbs'][] = ['label' => $topic->name, 'url' => ['/topic/view', 'id' => $topic->id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div>
    <div class="row">
        <div class="col-lg-12">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    </div>

    <div class="row">
        <div class="preview-item col-md-8 col-lg-offset-2">
            <img class="preview-image" src="<?= \common\models\Video::getParentFolderLink().$model->image->path ?>">
            <p class="text-center"><?= $message ?></p>
            <div class="text-center">
                <a href="<?= \yii\helpers\Url::toRoute($link) ?>"><?= $linktext ?></a>
            </div>
        </div>
    </div>

</div>
