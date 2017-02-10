<?php

namespace frontend\controllers;

use common\models\Section;
use common\models\Topic;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

class SectionController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $sections = Section::find()->all();
        return $this->render('index', ['sections' => $sections]);
    }

    public function actionView($id)
    {
        $query = Topic::find()->where(['section_id' => $id]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 10]);
        $models = $query
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('view', [
            'models' => $models,
            'pages' => $pages,
        ]);
//        $query = Topic::find()->where($id);
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//        ]);
//        return $this->render('view', ['dataProvider' => $dataProvider]);
    }

    protected function findModel($id)
    {
        if (($model = Section::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
