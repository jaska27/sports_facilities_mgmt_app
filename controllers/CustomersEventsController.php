<?php

namespace app\controllers;

use Yii;
use app\models\CustomersEvents;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomersEventsController implements the CRUD actions for CustomersEvents model.
 */
class CustomersEventsController extends Controller
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
     * Lists all CustomersEvents models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => CustomersEvents::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CustomersEvents model.
     * @param integer $event_id
     * @param integer $customer_id
     * @return mixed
     */
    public function actionView($event_id, $customer_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($event_id, $customer_id),
        ]);
    }

    /**
     * Creates a new CustomersEvents model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CustomersEvents();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'event_id' => $model->event_id, 'customer_id' => $model->customer_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CustomersEvents model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $event_id
     * @param integer $customer_id
     * @return mixed
     */
    public function actionUpdate($event_id, $customer_id)
    {
        $model = $this->findModel($event_id, $customer_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'event_id' => $model->event_id, 'customer_id' => $model->customer_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CustomersEvents model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $event_id
     * @param integer $customer_id
     * @return mixed
     */
    public function actionDelete($event_id, $customer_id)
    {
        $this->findModel($event_id, $customer_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CustomersEvents model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $event_id
     * @param integer $customer_id
     * @return CustomersEvents the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($event_id, $customer_id)
    {
        if (($model = CustomersEvents::findOne(['event_id' => $event_id, 'customer_id' => $customer_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
