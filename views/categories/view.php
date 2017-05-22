<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Categories */

$this->title = 'Kategoria ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Kategorie', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categories-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <div class="btn-group">
        <?= Html::a('Edytuj', ['update', 'id' => $model->category_id], ['class' => 'btn btn-primary']) ?>
        <?php
        if ($model->active=='1') {
            echo Html::a('Usuń', ['delete', 'id' => $model->category_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Czy na pewno chcesz usunąć tego klienta?',
                    'method' => 'post',
                ],
            ]);
        } elseif ($model->active=='0') {
            echo Html::a('Aktywuj', ['activate', 'id' => $model->category_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Czy na pewno chcesz aktywować tego klienta?',
                    'method' => 'post',
                ],
            ]);
        }
        ?>
        </div>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'category_id',
            'name',
            [
                'attribute' => 'active',
                'value' => (($model->active ==0) ? 'Nieaktywny': (($model->active ==1)? 'Aktywny' : '')),
            ],
            'description',
            'create_date',
            'last_update',
        ],
    ]) ?>

</div>
