<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Instructors */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Instruktor ' .  $model->first_name .' '. $model->last_name;
$this->params['breadcrumbs'][] = ['label' => 'Instruktorzy', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->instructor_id]];
$this->params['breadcrumbs'][] = 'Lista prowadzonych kursów';


?>
    <div class="instructors-events_list">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'name',
                'category.name',
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
            ],
        ]); ?>

    </div>