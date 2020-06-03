<?php

use yii\helpers\Html;
use app\helpers\BreadcrumbsHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\text\models\SubText */

$this->title = 'Update Sub Text: ' . $model->id;

$bc_cat = BreadcrumbsHelper::category($model->text->category);
$bc_text = BreadcrumbsHelper::text($model->text->id);
$this->params['breadcrumbs'] = array_merge($bc_cat, $bc_text);
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

?>
<div class="sub-text-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model, 'text' => $text,
    ]) ?>

</div>
