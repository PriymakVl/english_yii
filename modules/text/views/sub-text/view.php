<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\helpers\BreadcrumbsHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\text\models\SubText */

$this->title = $model->id;

$bc_cat = BreadcrumbsHelper::category($model->text->category);
$bc_text = BreadcrumbsHelper::text($model->text->id);
$this->params['breadcrumbs'] = array_merge($bc_cat, $bc_text);

\yii\web\YiiAsset::register($this);
?>
<div class="sub-text-view">
    <p>Текст: <b><?= $model->text->title ?></b></p>
    <h1>абзац: № <?= $model->number ?></h1>

    <p>
        <?= Html::a('Create', ['create', 'text_id' => $model->text->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'engl:ntext',
            'ru:ntext',
            'text_id',
            'state',
            'status',
        ],
    ]) ?>

</div>
