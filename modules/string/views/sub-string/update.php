<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Phrase */

$this->title = 'Update Phrase: ' . $model->id;
if ($model->text_id) $this->params['breadcrumbs'][] = ['label' => 'Фразы', 'url' => ['text', 'text_id' => $model->text_id]];
else $this->params['breadcrumbs'][] = ['label' => 'Фразы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="phrase-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
