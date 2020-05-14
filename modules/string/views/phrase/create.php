<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Phrase */

$this->title = 'Create Phrase';
$this->params['breadcrumbs'][] = ['label' => 'Phrases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="phrase-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
