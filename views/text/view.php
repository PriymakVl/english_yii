<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use app\helpers\BreadcrumbsHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Text */

$this->title = $model->title;

$this->params['breadcrumbs'] = BreadcrumbsHelper::create($model->category, false);
$this->params['breadcrumbs'][] = ['label' => $model->category->name, 'url' => '/category/texts?cat_id='.$model->category->id];
// debug($this->params);

\yii\web\YiiAsset::register($this);
?>
<div class="text-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Предложения', ['/string/text', 'text_id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Фразы', ['/substring/text', 'text_id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Слова', ['/word-text', 'text_id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php if ($model->ref): ?>
            <a href="<?= $model->ref ?> " class="btn btn-primary" target="_blank">Источник</a>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'engl:ntext',
            'ru:ntext',
            ['attribute' => 'cat_id', 'value' => function($model) {return $model->category->name;}],

        ],
    ]) ?>

</div>
