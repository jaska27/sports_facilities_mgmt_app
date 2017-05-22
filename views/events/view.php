<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Events */

$this->title = 'Kurs ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Kursy', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="events-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <div class="btn-group">
        <?= Html::a('Edytuj', ['update', 'id' => $model->event_id], ['class' => 'btn btn-primary']) ?>
        <?php
        if ($model->active=='1') {
            echo Html::a('Usuń', ['delete', 'id' => $model->event_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Czy na pewno chcesz usunąć tego klienta?',
                    'method' => 'post',
                ],
            ]);
        } elseif ($model->active=='0') {
            echo Html::a('Aktywuj', ['activate', 'id' => $model->event_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Czy na pewno chcesz aktywować tego klienta?',
                    'method' => 'post',
                ],
            ]);
        }
        ?>
        </div>

    <?= Html::a('Lista uczestników', ['customers', 'id' => $model->event_id], ['class' => 'btn btn-default', 'position' => 'left']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'event_id',
            'name',
            'description',
            [
                'attribute'=>'instructor_id',
                'value'=> (\app\models\Instructors::findOne($model->instructor_id))->first_name .' '.
                    (\app\models\Instructors::findOne($model->instructor_id))->last_name,
            ],
            [
                'attribute'=>'category_id',
                'value'=> (\app\models\Categories::findOne($model->category_id))->name,
            ],
            [
                'attribute' => 'active',
                'value' => (($model->active ==0) ? 'Nieaktywny': (($model->active ==1)? 'Aktywny' : '')),
            ],
            'create_date',
            'last_update',
        ],
    ]) ?>

</div>
