<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Перечень текстов';
$this->params['breadcrumbs'][] = '';

function create_link_title($model) {
    return Html::a($model->title, ['view', 'id' => $model->id]);
}

?>
<div class="text-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить текст', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'title:ntext',
            
            ['attribute' => 'title', 'format' => 'raw', 'value' => function($model) {return create_link_title($model);}
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
