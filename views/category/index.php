<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = '';

function create_link_name($model)
{
    if ($model->children) return Html::a($model->name, ['index', 'parent_id' => $model->id]);
    if ($model->texts) return Html::a($model->name, ['/text', 'cat_id' => $model->id]);
    return $model->name;
}
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать главную категорию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute' => 'name', 'format' => 'raw', 
                'value' => function($model) {return create_link_name($model);}
            ],

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}{update}{delete}{add}',

                'header' => 'Действия', 'headerOptions' => ['style' => 'color:#337ab7; text-align:center;'],

                'buttons' => [
                    'add' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-plus" style="margin-left: 10px;"></span>', $url);

                    },
                ],

                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'add') {
                        $url ='create?parent_id='.$model->id;
                        return $url;
                    }
                }
            ],
        ],
    ]); ?>


</div>
