<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\helpers\BreadcrumbsHelper;

$this->params['breadcrumbs'] = BreadcrumbsHelper::create($model);

\yii\web\YiiAsset::register($this);
?>
<div class="category-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить категорию?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Создать подкатегорию', ['create', 'parent_id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Добавить текст', ['/text/create', 'cat_id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            ['attribute' => 'name',  'format' => 'raw',
             'value' => function($model) { return Html::a($model->name, ['index', 'parent_id' => $model->id]); },
            ],
            ['attribute' => 'parent_id',  
             'value' => function($model) {return $model->parent ? $model->parent->name : 'нет';}
            ],
        ],
    ]) ?>

</div>
