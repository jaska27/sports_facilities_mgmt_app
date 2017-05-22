<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;

/* @var $this yii\web\View */
/* @var $model app\models\Customers */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Klient ' .  $model->first_name .' '. $model->last_name;
$this->params['breadcrumbs'][] = ['label' => 'Klienci', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->customer_id]];
$this->params['breadcrumbs'][] = ['label' => 'Lista aktywnych kursów', 'url' => ['events', 'id' => $model->customer_id]];
$this->params['breadcrumbs'][] = 'Lista kursów do zapisu';

?>
<div class="customers-events_sign_up_list">

    <h1><?= Html::encode($this->title).' - lista kursów do zapisu'?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'event_id',
            'category.name',
            'name',
            'description',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{sign}',
                'buttons' => [
                    'sign' => function($url, $model, $key) {
                        $options = array_merge([
                            'title' => Yii::t('yii', 'Sign'),
                            'aria-label' => Yii::t('yii', 'Sign'),
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to sign up on this event?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]);
                        return Html::a('<span class="glyphicon glyphicon-plus-sign"></span>',
                            ['sign','event_id' => $model->event_id,
                                'customer_id' => Yii::$app->getRequest()->getQueryParam('id')], $options);
                    }]
            ],
        ],
    ]); ?>
</div>