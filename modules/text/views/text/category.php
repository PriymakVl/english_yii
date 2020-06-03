<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\helpers\BreadcrumbsHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Перечень текстов категории: ' . $cat->name;

$this->params['breadcrumbs'] = BreadcrumbsHelper::category($cat, false);

function create_link_title($model) {
    return Html::a($model->title, ['view', 'id' => $model->id]);
}

?>
<div class="text-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить текст', ['create', 'cat_id' => $cat->id], ['class' => 'btn btn-success']) ?>
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
