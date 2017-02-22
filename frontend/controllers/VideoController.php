<?php

namespace frontend\controllers;


use Yii;
use common\models\Subscription;
use frontend\models\Section;
use frontend\models\Topic;
use frontend\models\Video;
use yii\web\NotFoundHttpException;

/* @var $user \common\models\User */

class VideoController extends \yii\web\Controller
{
    public function actionView($id)
    {

        $model = $this->findModel($id);
        $topic = Topic::findOne($model->topic_id);
        $section = Section::findOne($topic->section_id);
        $user = Yii::$app->user->identity;
        if(isset($user) && $user->hasAccessFor($section)) {
            return $this->render('view', ['model' => $model, 'topic' => $topic, 'section' => $section]);
        } else {
            $this->redirect(['preview', 'id'=> $id]);
        }

    }

    public function actionPreview($id)
    {
        $model = $this->findModel($id);
        $topic = Topic::findOne($model->topic_id);
        $section = Section::findOne($topic->section_id);
        $user = Yii::$app->user->identity;
        if(isset($user) && $user->hasAccessFor($section)) {
            $this->redirect(['view', 'id'=> $id]);
        } else {
            $path = $model->image->path;
            return $this->render('preview', ['path' => $path]);
        }
    }

    protected function findModel($id)
    {
        if (($model = Video::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}