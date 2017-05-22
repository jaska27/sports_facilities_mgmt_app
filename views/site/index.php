<?php

/* @var $this yii\web\View */
/* @var $model app\models\Customers */

$this->title = 'Zarządzanie obiektem sportowym';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><h4>Grafik na dzisiaj - <?= date('d.m.Y') ?><h4></div>
                    <div class="panel-body">
                        <?= \yii2fullcalendar\yii2fullcalendar::widget(array(
                            'events'=> $events,
                            'header'=>[
                                'left'=>'',
                                'center'=> '',
                                'right'=> ''
                            ],
                            'defaultView'=>'agendaDay',
                        )); ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><h4>Statystyki<h4></div>
                    <div class="panel-body">
                        <blockquote>
                            <p>Liczba klientów</p>
                            <footer>aktywni <strong><?= \app\controllers\SiteController::getNumberOfActiveCustomers(); ?></strong></footer>
                            <footer>nieaktywni <strong><?= \app\controllers\SiteController::getNumberOfInactiveCustomers(); ?></strong></footer>
                        </blockquote>
                        <blockquote>
                            <p>Liczba instruktorów</p>
                            <footer>aktywni <strong><?= \app\controllers\SiteController::getNumberOfActiveInstructors(); ?></strong></footer>
                            <footer>nieaktywni <strong><?= \app\controllers\SiteController::getNumberOfInactiveInstructors(); ?></strong></footer>
                        </blockquote>
                        <blockquote>
                            <p>Liczba kursów</p>
                            <footer>aktywne <strong><?= \app\controllers\SiteController::getNumberOfActiveEvents(); ?></strong></footer>
                            <footer>nieaktywne <strong><?= \app\controllers\SiteController::getNumberOfInactiveEvents(); ?></strong></footer>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
