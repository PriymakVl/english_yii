<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TextWord */

$this->title = 'Create Text Word';
$this->params['breadcrumbs'][] = ['label' => 'Text Words', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="text-word-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
