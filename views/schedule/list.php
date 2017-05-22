<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Schedule */
/* @var $searchModel app\models\ScheduleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Grafik kursów';
$this->params['breadcrumbs'][] = ['label' => 'Kalendarz', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="schedule-list">

    <h1><?= Html::encode($this->title).' - lista' ?></h1>

    <p>
        <?= Html::button('Dodaj do grafiku', ['value'=>Url::to('/schedule/create'),
            'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </p>

    <?php
    Modal::begin([
        'header' => '<h2>Dodaj wydarzenie do grafiku</h2>',
        'id' => 'modal',
        'size' => 'modal-lg',
    ]);

    echo "<div id='modalContent'></div>";

    Modal::end();
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute'=>'event_id',
                'value' => 'event.name'
            ],
            'date',
            'time_start',
            'time_end',
            [
                'attribute'=>'active',
                'filter' => ['1'=>'Aktywny', '0'=>'Nieaktywny'],
                'value' => function($model, $key, $index)
                {
                    if($model->active == $model::STATUS_INACTIVE)
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