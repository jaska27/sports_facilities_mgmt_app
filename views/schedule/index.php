<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ScheduleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Grafik kursów';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schedule-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button('Dodaj do grafiku', ['value'=>Url::to('/schedule/create'),
            'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
        <?= Html::a('Lista', ['schedule/list'], ['class' => 'btn btn-default']) ?>
    </p>

    <?php
        Modal::begin([
            'header' => '<h2>Dodaj wydarzenie do grafiku</h2>',
            'id' => 'modal',
            'size' => 'modal-lg',
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
    ?>

    <?= \yii2fullcalendar\yii2fullcalendar::widget(array(
        'events'=> $events,
        'header'=>[
                'left'=>'prev,next, today',
                'center'=> 'title',
                'right'=> 'month,agendaWeek,agendaDay'
            ],
    )); ?>
</div>