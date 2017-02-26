<?php

namespace frontend\controllers;


use common\models\Subscription;
use common\models\User;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Yii;
use common\models\Like;
use frontend\models\Section;
use frontend\models\Topic;
use frontend\models\Video;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\data\Pagination;

/* @var $user \common\models\User */

class VideoController extends \yii\web\Controller
{
    public function actionView($id)
    {

        $model = $this->findModel($id);
        $topic = Topic::findOne($model->topic_id);
        $section = Section::findOne($topic->section_id);
        $user = Yii::$app->user->identity;

        if(Like::findOne(['user_id' => $user->id, 'video_id' => $id])) {
            $message = 'Remove from favorites';
        } else {
            $message = 'Add to favorites';
        }

        if(isset($user) && $user->hasAccessFor($section)) {
            return $this->render('view', ['model' => $model, 'topic' => $topic, 'section' => $section, 'favorites_msg' => $message]);
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
        } else if (!isset($user)){
            $link = 'site/login';
            $linktext = 'Login';
            $message = 'Please login to view this content!';
            return $this->render('preview', ['section' => $section, 'topic' => $topic, 'model' => $model,
                'message' => $message, 'link' => $link, 'linktext' => $linktext]);
        } else {
            $link = 'site/contact';
            $linktext = 'Contact';
            $message = "You don't have access to this section. Please contact the administrator!";
            return $this->render('preview', ['section' => $section, 'topic' => $topic, 'model' => $model,
                'message' => $message, 'link' => $link, 'linktext' => $linktext]);
        }
    }

    public function actionFavorites()
    {
        $user_id = Yii::$app->user->identity->getId();
        $video_id = Yii::$app->request->post()['video_id'];
        $liked = Like::findOne(['user_id' => $user_id, 'video_id' => $video_id]);
        if(!$liked) {
            $liked = new Like();
            $liked->user_id = $user_id;
            $liked->video_id = $video_id;
            $liked->save();
            $msg = 'Remove from favorites';
        } else {
            $liked->delete();
            $msg = 'Add to favorites';
        }
        echo json_encode(array('result' => 'success', 'msg' => $msg));
    }

    public function actionFave()
    {
        $user = Yii::$app->user->identity;
        if($user) {
            $query = Video::find()->joinWith('likes')->andWhere([Like::tableName().'.user_id' => $user->getId()]);//AndWhere(['topic_id' => $id]);
            $countQuery = clone $query;
            $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 9]);
            $models = $query
                ->offset($pages->offset)
                ->limit($pages->limit)
                ->all();

            return $this->render('fave', [
                'models' => $models,
                'pages' => $pages,
                'id' => Yii::$app->user->id,
            ]);
        }  else {
            //throw new NotFoundHttpException('The requested page does not exist.');
            throw new ForbiddenHttpException('You are not authorized to access this page');
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