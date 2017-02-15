<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TopicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Topics';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="topic-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Topic', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'name',
            //'slug',
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
                'value' => function($data) {
                    return \common\models\Section::getSection($data->section_id);
                },
            ],
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
