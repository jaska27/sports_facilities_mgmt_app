<?php

namespace app\controllers;

use app\models\CustomersEvents;
use app\models\Events;
use Yii;
use app\models\Customers;
use app\models\CustomersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * CustomersController implements the CRUD actions for Customers model.
 */
class CustomersController extends Controller
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
     * Lists all Customers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Customers model.
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
     * Creates a new Customers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Customers();

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
     * Updates an existing Customers model.
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
            return $this->redirect(['view', 'id' => $model->customer_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Activates an existing Customers model.
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
            return $this->redirect(['view', 'id' => $model->customer_id]);
    }

    /**
     * Changes the status field of an existing Customers model.
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
     * Finds the Customers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the events from existing models on which the customer is signed up.
     * @param integer $id
     * @return mixed
     */
    public function actionEvents($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => CustomersEvents::find()
                ->joinWith('customer')
                ->joinWith('event')
                ->where(['customers_events.customer_id'=>$id]),
        ]);

        return $this->render('events_list', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the events from existing models on which the customer is not signed up.
     * @param integer $id
     * @return mixed
     */
    public function actionSignuplist($id)
    {
        //The list of events on which the customer is not signed up.
        /* SELECT * FROM events WHERE event_id NOT IN (
            SELECT event_id FROM customers_events WHERE customer_id = $id)*/
        $subQuery = CustomersEvents::find()
            ->select('event_id')
            ->where(['customer_id' => $id]);

        $dataProvider = new ActiveDataProvider(array(
            'query' => Events::find()
                ->where(['not in', 'events.event_id', $subQuery]),
        ));

        return $this->render('events_sign_up_list', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Check out the customer from selected event.
     * @param integer $customer_id
     * @param integer $event_id
     * @return mixed
     */
    public function actionCheckout ($event_id, $customer_id){
        $model = CustomersEvents::find()
            ->where(['event_id'=>$event_id])
            ->andWhere(['customer_id'=>$customer_id])
        ->one();

        $model->delete();
        return $this->redirect(['events', 'id' => $customer_id]);

    }

    /**
     * Sign up the customer on selected event.
     * @param integer $customer_id
     * @param integer $event_id
     * @return mixed
     */
    public function actionSign ($event_id, $customer_id){
        $model = new CustomersEvents();
        $model->event_id = $event_id;
        $model->customer_id = $customer_id;
        $model->create_date = date('Y-m-d H:m:s');
        $model->save();
        return $this->redirect(['events', 'id' => $customer_id]);
    }
}
