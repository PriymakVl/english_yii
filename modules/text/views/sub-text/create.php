<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\text\models\SubText */

$this->title = 'Create Sub Text';
$this->params['breadcrumbs'][] = ['label' => 'Sub Texts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sub-text-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model, 'text' => $text,
    ]) ?>

</div>
