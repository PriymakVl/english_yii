<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\helpers\BreadcrumbsHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'] = BreadcrumbsHelper::category($parent);

function create_link_name($model)
{
    if ($model->children) return Html::a($model->name, ['index', 'parent_id' => $model->id]);
    if ($model->texts) return Html::a($model->name, ['texts', 'cat_id' => $model->id]);
    return $model->name;
}
?>
<style type="text/css">
    td:nth-child(3) a {
        margin-right: 10px;
    }
</style>

<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать главную категорию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url); 
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                    },
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                    },
                    'add' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-plus"></span>', $url);
                    },
                ],

                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'add') {
                        return '/category/create?parent_id='.$model->id;
                    }
                    else if ($action === 'view') {
                        return '/category/view?id='.$model->id;
                    }
                    else if ($action === 'update') {
                        return '/category/update?id='.$model->id;
                    }
                    else if ($action === 'delete') {
                        return '/category/delete?id='.$model->id;
                    }
                }
            ],
        ],
    ]); ?>


</div>
