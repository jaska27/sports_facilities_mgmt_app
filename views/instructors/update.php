<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Instructors */

$this->title = 'Instruktor ' . $model->first_name .' '. $model->last_name;
$this->params['breadcrumbs'][] = ['label' => 'Instruktorzy', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->instructor_id]];
$this->params['breadcrumbs'][] = 'Edytuj dane';

?>
<div class="instructors-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
