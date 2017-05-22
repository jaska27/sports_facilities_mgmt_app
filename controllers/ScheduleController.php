<?php

namespace app\controllers;

use app\models\Events;
use app\models\Rooms;
use Yii;
use app\models\Schedule;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\ScheduleSearch;
use yii\db\Expression;

/**
 * ScheduleController implements the CRUD actions for Schedule model.
 */
class ScheduleController extends Controller
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
     * Lists all Schedule models.
     * @return mixed
     */
    public function actionIndex()
    {
        $schedule = Schedule::find()
            ->where(['active'=>Schedule::STATUS_ACTIVE])
            ->all();
        $events = [];

        foreach ($schedule AS $app){
            $event = new \yii2fullcalendar\models\Event();
            $event->id = $app->schedule_id;
            $event->title = Events::findOne([
                'event_id' => $app->event_id,
            ])->name;
            $event->start = date('Y-m-d\TH:i:s\Z',strtotime($app->date.' '.$app->time_start));
            $event->end = date('Y-m-d\TH:i:s\Z',strtotime($app->date.' '.$app->time_end));
            $event->backgroundColor = $this->eventColour($app);
            $event->borderColor = $this->eventBorderColour($app);
            $events[] = $event;
        }

        return $this->render('index', [
            'events' => $events,
        ]);
    }

    public function eventColour($schedule)
    {
        if($schedule->room == Rooms::ROOM_1)  return '#3a87ad';
        else if ($schedule->room == Rooms::ROOM_2) return '#5cd65c';
    }

    public function eventBorderColour($schedule)
    {
        if($schedule->room == Rooms::ROOM_1)  return '#337ab7';
        else if ($schedule->room == Rooms::ROOM_2) return '#5cc25c';
    }

    /**
     * Displays a single Schedule model.
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
     * Creates a new Schedule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Schedule();

        if ($model->load(Yii::$app->request->post())) {
            $model->active = $model::STATUS_ACTIVE;
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Schedule model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $schedule_id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->schedule_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Activates an existing Schedule model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionActivate($id)
    {
        $model = $this->findModel($id);
        $model->active = $model::STATUS_ACTIVE;
        $model->save();
        return $this->redirect(['view', 'id' => $model->schedule_id]);
    }

    /**
     * Deletes an existing Schedule model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->active = $model::STATUS_INACTIVE;
        $model->save();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Schedule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Schedule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Schedule::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the events in schedule and show them in list view.
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new ScheduleSearch();

        $dataProvider = new ActiveDataProvider([
            'query' => Schedule::find()
                ->joinWith('event')
                ->where(['>=', 'date', new Expression('NOW()')])
        ]);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
