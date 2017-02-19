<?php

namespace frontend\controllers;

use common\models\Section;
use common\models\Topic;
use common\models\Video;
use yii\data\Pagination;

class TopicController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView($id)
    {
        $query = Video::find()->where(['topic_id' => $id]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 9]);
        $models = $query
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $topic = Topic::findOne($id);
        $section = Section::findOne($topic->section_id);

        return $this->render('view', [
            'models' => $models,
            'pages' => $pages,
            'topic' => $topic,
            'section' => $section,
        ]);
    }

}
