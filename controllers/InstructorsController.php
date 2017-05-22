<?php

namespace app\controllers;

use app\models\Events;
use Yii;
use app\models\Instructors;
use app\models\InstructorsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * InstructorsController implements the CRUD actions for Instructors model.
 */
class InstructorsController extends Controller
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
     * Lists all Instructors models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InstructorsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Instructors model.
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
     * Creates a new Instructors model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Instructors();

        if ($model->load(Yii::$app->request->post())) {
            $model->active = $model::STATUS_ACTIVE;
            $model->create_date = date('Y-m-d H:m:s');
            $model->last_update = date('Y-m-d H:m:s');
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Instructors model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->last_update = date('Y-m-d H:m:s');
            $model->save();
            return $this->redirect(['view', 'id' => $model->instructor_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Activates an existing Instructors model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionActivate($id)
    {
        $model = $this->findModel($id);
        $model->last_update = date('Y-m-d H:m:s');
        $model->active = $model::STATUS_ACTIVE;
        $model->save();
        return $this->redirect(['view', 'id' => $model->instructor_id]);
    }

    /**
     * Changes the status field of an existing Instructors model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->last_update = date('Y-m-d H:m:s');
        $model->active = $model::STATUS_INACTIVE;
        $model->save();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Instructors model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Instructors the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Instructors::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Displays a list of events for a single Instructors model.
     * @param integer $id
     * @return mixed
     */
    public function actionEvents($id)
    {
        $searchModel = new InstructorsSearch();

        $dataProvider = new ActiveDataProvider([
            'query' => Events::find()->with('instructor')->where(['instructor_id'=>$id]),
        ]);

        return $this->render('events_list', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
        ]);
    }
}
