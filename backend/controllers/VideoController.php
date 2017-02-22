<?php

namespace backend\controllers;

use common\models\Section;
use Yii;
use common\models\Video;
use common\models\Topic;
use backend\models\VideoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VideoController implements the CRUD actions for Video model.
 */
class VideoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Video models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VideoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Video model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Video model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Video();
//        $post = Yii::$app->request->post();
//
//        if($post) {
//            $model->load($post);
//            $model->uploadVideo();
//            $model->save();
//        }
//
//        return $this->render('create', ['model' => $model]);



        if ($model->load(Yii::$app->request->post()) && $model->uploadVideo() && $model->uploadImage() && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Video model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->uploadVideo() && $model->uploadImage() && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            if($model->topic_id) {
                $section_id = $model->getTopic()->one()->section_id;
                $section = Section::getSection($section_id);

                $model->section = $section;
            }
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Video model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Video model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Video the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Video::findOneAvailable($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionLists($id)
    {
        $countTopics = Topic::find()
            ->where(['section_id' => $id])
            ->count();

        $topics = Topic::find()
            ->where(['section_id'=>$id])
            ->all();

        echo "<option>Select topic</option>";
        if($countTopics > 0)
        {

            foreach ($topics as $row) {
                echo "<option value='".$row->id."'>".$row->name."</option>";
            }
        }
    }
}
