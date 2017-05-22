<?php

namespace app\controllers;

use app\models\Customers;
use Yii;
use app\models\Events;
use app\models\EventsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\CustomersEvents;
use yii\data\ActiveDataProvider;

/**
 * EventsController implements the CRUD actions for Events model.
 */
class EventsController extends Controller
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
     * Lists all Events models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Events model.
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
     * Creates a new Events model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Events();

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
     * Updates an existing Events model.
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
            return $this->redirect(['view', 'id' => $model->event_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Activates an existing Events model.
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
        return $this->redirect(['view', 'id' => $model->event_id]);
    }

    /**
     * Deletes an existing Events model.
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
     * Finds the Events model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Events the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Events::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the customers from existing models.
     * @param integer $id
     * @return mixed
     */
    public function actionCustomers($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => CustomersEvents::find()
                ->joinWith('customer')
            ->where([
                'event_id'=>$id,
                'active'=>Customers::STATUS_ACTIVE,
            ])
        ]);

        return $this->render('customers_list', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
        ]);
    }
}
