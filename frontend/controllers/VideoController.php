<?php

namespace frontend\controllers;

use common\models\Section;
use common\models\Topic;
use common\models\Video;

class VideoController extends \yii\web\Controller
{
    public function actionView($id)
    {
        $model = Video::findOne($id);
        $topic = Topic::findOne($model->topic_id);
        $section = Section::findOne($topic->section_id);
        return $this->render('view', ['model' => $model, 'topic' => $topic, 'section' => $section]);
    }

    public function actionPreview()
    {
        return $this->render('preview');
    }

}
