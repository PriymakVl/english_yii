<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Text */

$this->title = $model->title;

$this->params['breadcrumbs'][] = '<a href="#">link</link>';
// Html::a($model->category->name, ['/text', 'cat_id' => $model->category->id]);
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="text-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Предложения', ['/sentense', 'id_text' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Слова', ['/text-word', 'id_text' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'engl:ntext',
            'ru:ntext',
            'created',
            'status',
        ],
    ]) ?>

</div>
