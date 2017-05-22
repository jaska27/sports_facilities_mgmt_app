<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Customers */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Klient ' .  $model->first_name .' '. $model->last_name;
$this->params['breadcrumbs'][] = ['label' => 'Klienci', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->customer_id]];
$this->params['breadcrumbs'][] = 'Lista aktywnych kursów';

?>
<div class="customers-events_list">

    <h1><?= Html::encode($this->title).' - lista aktywnych kursów' ?></h1>

    <p>
        <?= Html::a('Nowy kurs', ['signuplist', 'id' => $model->customer_id],
            ['class' => 'btn btn-success', 'position' => 'left']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class'=> 'yii\grid\SerialColumn'],
            'event.category.name',
            'event.name',
            'create_date',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{checkout}',
                'buttons' => [
                    'checkout' => function($url, $model, $key) {
                    $options = array_merge([
                        'title' => Yii::t('yii', 'Checkout'),
                        'aria-label' => Yii::t('yii', 'Checkout'),
                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                        'data-pjax' => '0',
                    ]);
                    return Html::a('<span class="glyphicon glyphicon-minus-sign"></span>', $url, $options);
                },]
            ],
        ]
    ]); ?>

</div>