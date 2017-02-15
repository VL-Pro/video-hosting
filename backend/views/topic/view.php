<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Topic */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Topics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="topic-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'slug',
            'description',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($model) {
                    if($model->status == \common\models\Section::STATUS_ACTIVE) {
                        return "Active";
                    } elseif($model->status == \common\models\Section::STATUS_INV) {
                        return "Invisible";
                    } else {
                        return "Deleted";
                    }
                }
            ],
            [
                'attribute' => 'section_id',
                'format' => 'raw',
                'value' => \common\models\Section::getSection($model->section_id),
            ],
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => $model->getDate($model->created_at),
            ],
            [
                'attribute' => 'created_by',
                'format' => 'raw',
                'value' => $model->getCreatedBy('username'),
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'raw',
                'value' => $model->getDate($model->updated_at),
            ],
            [
                'attribute' => 'updated_by',
                'format' => 'raw',
                'value' => $model->getUpdatedBy('username'),
            ],
        ],
    ]) ?>

</div>
