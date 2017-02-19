<?php
/**
 * Created by PhpStorm.
 * User: pvp
 * Date: 2/17/2017
 * Time: 12:45 PM
 */

use yii\helpers\Html;

/* @var $model \common\models\Video */
/* @var $section \common\models\Section */
/* @var $topic \common\models\Topic */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => $section->name, 'url' => ['/section/view', 'id' => $section->id]];
$this->params['breadcrumbs'][] = ['label' => $topic->name, 'url' => ['/topic/view', 'id' => $topic->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
    <h1><?= Html::encode($this->title) ?></h1>
    <video  width = "700" controls>
        <source src = "<?= \common\models\Video::getParentFolderLink().$model->path; ?>" type='video/mp4'>
    </video>
    <p><?= $model->description ?></p>
</div>