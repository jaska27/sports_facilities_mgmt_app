<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Events */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kurs ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Kursy', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->event_id]];
$this->params['breadcrumbs'][] = 'Lista uczestników';

?>
<div class="events-customers_list">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class'=> 'yii\grid\SerialColumn'],
            'customer_id',
            'customer.first_name',
            'customer.last_name',
            'customer.pesel',
            'create_date',
        ],
    ]); ?>

</div>