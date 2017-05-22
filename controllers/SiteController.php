<?php

namespace app\controllers;

use app\models\Customers;
use app\models\Events;
use app\models\Instructors;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Schedule;

class SiteController extends Controller
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
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $schedule = Schedule::find()->all();
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
        //return $this->render('index');
    }

    public function eventColour($schedule)
    {
        if($schedule->room == 1)  return '#3a87ad';
        else if ($schedule->room == 2) return '#5cd65c';
    }

    public function eventBorderColour($schedule)
    {
        if($schedule->room == 1)  return '#337ab7';
        else if ($schedule->room == 2) return '#5cc25c';
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    //Finds the number of active customers.
    public static function getNumberOfActiveCustomers()
    {
        // SELECT COUNT(*) FROM `customers` WHERE `active` = 1
        $count = Customers::find()
            ->where(['active' => Customers::STATUS_ACTIVE])
            ->count();

        return $count;
    }

    //Finds the number of inactive customers.
    public static function getNumberOfInactiveCustomers()
    {
        // SELECT COUNT(*) FROM `customers` WHERE `active` = 0
        $count = Customers::find()
            ->where(['active' => Customers::STATUS_INACTIVE])
            ->count();

        return $count;
    }

    //Finds the number of active instructors.
    public static function getNumberOfActiveInstructors()
    {
        // SELECT COUNT(*) FROM `instructors` WHERE `active` = 1
        $count = Instructors::find()
            ->where(['active' => Instructors::STATUS_ACTIVE])
            ->count();

        return $count;
    }

    //Finds the number of inactive instructors.
    public static function getNumberOfInactiveInstructors()
    {
        // SELECT COUNT(*) FROM `instructors` WHERE `active` = 0
        $count = Instructors::find()
            ->where(['active' => Instructors::STATUS_INACTIVE])
            ->count();

        return $count;
    }

    //Finds the number of active events.
    public static function getNumberOfActiveEvents()
    {
        // SELECT COUNT(*) FROM `events` WHERE `active` = 1
        $count = Events::find()
            ->where(['active' => Events::STATUS_ACTIVE])
            ->count();

        return $count;
    }

    //Finds the number of inactive events.
    public static function getNumberOfInactiveEvents()
    {
        // SELECT COUNT(*) FROM `events` WHERE `active` = 0
        $count = Events::find()
            ->where(['active' => Events::STATUS_INACTIVE])
            ->count();

        return $count;
    }
}
