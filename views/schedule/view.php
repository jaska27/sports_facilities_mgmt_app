<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Schedule */

$this->title = 'Termin kursu ' . \app\models\Events::findOne(['event_id' => $model-> event_id,])->name;
$this->params['breadcrumbs'][] = ['label' => 'Grafik', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schedule-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <div class="btn-group">
        <?= Html::a('Edytuj termin', ['update', 'id' => $model->schedule_id], ['class' => 'btn btn-primary']) ?>
        <?php
        if ($model->active=='1') {
            echo Html::a('Usuń', ['delete', 'id' => $model->schedule_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Czy na pewno chcesz usunąć tego klienta?',
                    'method' => 'post',
                ],
            ]);
        } elseif ($model->active=='0') {
            echo Html::a('Aktywuj', ['activate', 'id' => $model->schedule_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Czy na pewno chcesz aktywować tego klienta?',
                    'method' => 'post',
                ],
            ]);
        }
        ?>
        </div>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'schedule_id',
            [
                'attribute'=>'event_id',
                'value'=> \app\models\Events::findOne([
                    'event_id' => $model-> event_id,
                ])->name,
            ],
            'date',
            'time_start',
            'time_end',
            [
                'attribute'=>'room',
                'value'=> \app\models\Rooms::findOne([
                    'room_id' => $model-> room,
                ])->name,
            ],
            [
                'attribute' => 'active',
                'value' => (($model->active ==0) ? 'Nieaktywny': (($model->active ==1)? 'Aktywny' : '')),
            ],
        ],
    ]) ?>

</div>
