<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CustomersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Klienci';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customers-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button('Dodaj nowego', ['value'=>Url::to('/customers/create'),
            'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </p>

    <?php
    Modal::begin([
        'header' => '<h2>Dodaj nowego klienta</h2>',
        'id' => 'modal',
        'size' => 'modal-lg',
    ]);

    echo "<div id='modalContent'></div>";

    Modal::end();
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'customer_id',
            'first_name',
            'last_name',
            'pesel',
            'email:email',
            [
                'attribute'=>'active',
                'filter' => ['1'=>'Aktywny', '0'=>'Nieaktywny'],
                'value' => function($model, $key, $index)
                {
                    if($model->active == '0')
                    {
                        return 'Nieaktywny';
                    }
                    else
                    {
                        return 'Aktywny';
                    }
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>