<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use app\helpers\BreadcrumbsHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Text */

$this->title = $model->title;

$bc_cat = BreadcrumbsHelper::category($model->category);
$bc_text = BreadcrumbsHelper::text($model->id);
$this->params['breadcrumbs'] = array_merge($bc_cat, $bc_text);


\yii\web\YiiAsset::register($this);
?>
<div class="text-view">
    
    <p>Категория: <b><?= $model->category->name ?></b></p>

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

        <?php if ($model->ref): ?>
            <a href="<?= $model->ref ?> " class="btn btn-primary" target="_blank">Источник</a>
        <?php endif; ?>
    </p>

     <table class="table table-striped table-bordered">
            <tr>
                <th>Engl</th>
                <th>Ru</th>
            </tr>
            <tr>
                <td>
                    <?= str_replace("\r\n", '<br><br>', $model->engl) ?>
                </td>
                <td>
                    <?= str_replace("\r\n", '<br><br>', $model->ru) ?>
                </td>
            </tr>
        </table>

</div>
