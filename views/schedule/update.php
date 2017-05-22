<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Schedule */

$this->title = 'Termin kursu ' . \app\models\Events::findOne(['event_id' => $model-> event_id,])->name;
$this->params['breadcrumbs'][] = ['label' => 'Grafik', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->schedule_id]];
$this->params['breadcrumbs'][] = 'Edycja terminu';

?>
<div class="schedule-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
