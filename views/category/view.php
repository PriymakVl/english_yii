<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
$parent = $model->parent ? $model->parent : null;
$progenitor = $parent->parent ? $parent->parent : null;
$root = $progenitor->parent ? $progenitor->parent : null;

$this->title = $model->name;
if ($root) $this->params['breadcrumbs'][] = ['label' => $root->name, 'url' => ['/category/view', 'id' => $root->id]];
if ($progenitor) $this->params['breadcrumbs'][] = ['label' => $progenitor->name, 'url' => ['/category/view', 'id' => $progenitor->id]];
if ($parent) $this->params['breadcrumbs'][] = ['label' => $parent->name, 'url' => ['/category/view', 'id' => $parent->id]];
$this->params['breadcrumbs'][] = $this->title;

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
            'name',
            ['attribute' => 'parent_id',  
             'value' => function($model) {return $model->parent ? $model->parent->name : 'нет';}],
            ],
    ]) ?>

</div>
