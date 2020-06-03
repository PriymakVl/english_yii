<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\BreadcrumbsHelper;

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

    <?php if ($categories): ?>
        <table class="table table-striped table-bordered">
            <tr>
                <th>#</th>
                <th>Название</th>
                <th>Действие</th>
            </tr>
            <? $num = 1; ?>
            <?php foreach ($categories as $cat): ?>
                <tr>
                    <td><?= $num ?></td>
                    <td>
                        <?= Html::a($cat->name, ['categories', 'parent_id' => $cat->id]) ?>
                    </td>
                    <td></td>
                </tr>
                <? $num++; ?>
            <?php endforeach; ?>
        </table>
    <?php endif ?>

</div>
