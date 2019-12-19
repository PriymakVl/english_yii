<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TextWord */

$this->title = 'Добавить слова для текста';
$this->params['breadcrumbs'][] = ['label' => 'Текст', 'url' => ['index', 'id_text' => $model->id_text]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="text-word-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
