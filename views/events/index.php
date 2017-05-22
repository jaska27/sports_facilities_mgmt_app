<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EventsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kursy';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="events-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button('Dodaj nowy', ['value'=>Url::to('/events/create'),
            'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
        <?= Html::a('Kategorie', ['categories/index'], ['class' => 'btn btn-default']) ?>
    </p>

    <?php
    Modal::begin([
        'header' => '<h2>Dodaj nowy kurs</h2>',
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
            'name',
            'description',
            [
                'attribute'=>'category_id',
                'filter'=>ArrayHelper::map(\app\models\Categories::find()->asArray()->all(), 'category_id', 'name'),
                'value'=>'category.name',
            ],
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
