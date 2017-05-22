<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Customers */

$this->title = 'Klient ' .  $model->first_name .' '. $model->last_name;
$this->params['breadcrumbs'][] = ['label' => 'Klienci', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->customer_id]];
$this->params['breadcrumbs'][] = 'Edycja danych';

?>
<div class="customers-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>