<?php

namespace frontend\controllers;

use frontend\models\Section;
use frontend\models\Topic;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

class SectionController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $query = Section::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 9]);
        $sections = $query
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        //$sections = Section::find()->all();
        return $this->render('index', ['sections' => $sections, 'pages' => $pages]);
    }

    public function actionView($id)
    {
        $section = $this->findModel($id);

        $query = Topic::find()->andWhere(['section_id' => $id]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 10]);
        $models = $query
                ->offset($pages->offset)
                ->limit($pages->limit)
                ->all();



        return $this->render('view', [
            'models' => $models,
            'pages' => $pages,
            'section' => $section,
        ]);

    }

    public function actionOpen($name)
    {
        $section = $this->findModelByName($name);

        $query = Topic::find()->andWhere(['section_id' => $section->id]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 10]);
        $models = $query
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();



        return $this->render('view', [
            'models' => $models,
            'pages' => $pages,
            'section' => $section,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Section::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelByName($name)
    {
        if (($model = Section::findOne(['name' => $name])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
