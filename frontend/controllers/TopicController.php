<?php

namespace frontend\controllers;

use frontend\models\Section;
use frontend\models\Topic;
use frontend\models\Video;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

class TopicController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView($id)
    {
        $topic = $this->findModel($id);

        $query = Video::find()->AndWhere(['topic_id' => $id]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 9]);
        $models = $query
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();


        $section = Section::findOne($topic->section_id);

        return $this->render('view', [
            'models' => $models,
            'pages' => $pages,
            'topic' => $topic,
            'section' => $section,
        ]);
    }

    public function actionOpen($topic_name)
    {
        $topic = $this->findModelByName($topic_name);

        $query = Video::find()->AndWhere(['topic_id' => $topic->id]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 9]);
        $models = $query
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();


        $section = Section::findOne($topic->section_id);

        return $this->render('view', [
            'models' => $models,
            'pages' => $pages,
            'topic' => $topic,
            'section' => $section,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Topic::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelByName($name)
    {
        if (($model = Topic::findOne(['topic.name' => $name])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
