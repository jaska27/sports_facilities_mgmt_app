<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Events */

$this->title = 'Kurs ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Kursy', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->event_id]];
$this->params['breadcrumbs'][] = 'Edycja danych';
?>
<div class="events-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
