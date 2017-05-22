<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kategorie';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categories-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button('Dodaj nową', ['value'=>Url::to('/categories/create'),
            'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </p>

    <?php
    Modal::begin([
        'header' => '<h2>Dodaj nową kategorię</h2>',
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
