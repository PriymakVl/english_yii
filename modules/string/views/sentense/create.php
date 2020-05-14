<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Sentense */

$this->title = 'Create Sentense';
$this->params['breadcrumbs'][] = ['label' => 'Sentenses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sentense-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
