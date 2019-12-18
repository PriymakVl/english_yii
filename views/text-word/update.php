<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TextWord */

$this->title = 'Update Text Word: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Text Words', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="text-word-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
