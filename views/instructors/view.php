<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Instructors */

$this->title = 'Instruktor ' .  $model->first_name .' '. $model->last_name;
$this->params['breadcrumbs'][] = ['label' => 'Instruktorzy', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instructors-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <div class="btn-group">
        <?= Html::a('Edytuj', ['update', 'id' => $model->instructor_id], ['class' => 'btn btn-primary']) ?>

        <?php
        if ($model->active=='1') {
            echo Html::a('Usuń', ['delete', 'id' => $model->instructor_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Czy na pewno chcesz usunąć tego klienta?',
                    'method' => 'post',
                ],
            ]);
        } elseif ($model->active=='0') {
            echo Html::a('Aktywuj', ['activate', 'id' => $model->instructor_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Czy na pewno chcesz aktywować tego klienta?',
                    'method' => 'post',
                ],
            ]);
        }
        ?>
    </div>

        <?= Html::a('Lista kursów', ['events', 'id' => $model->instructor_id], ['class' => 'btn btn-default', 'position' => 'left']) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'instructor_id',
            'first_name',
            'last_name',
            'pesel',
            [
                'attribute' => 'sex',
                'value' => (($model->sex =='K') ? 'Kobieta': (($model->sex =='M')? 'Mężczyzna' : '')),
            ],
            'email:email',
            'phone',
            'street',
            'city',
            'postal_code',
            'id_card',
            [
                'attribute' => 'active',
                'value' => (($model->active ==0) ? 'Nieaktywny': (($model->active ==1)? 'Aktywny' : '')),
            ],
            'description',
            'create_date',
            'last_update',
        ],
    ]) ?>

</div>
