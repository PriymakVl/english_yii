<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Добавить фразы';
$this->params['breadcrumbs'][] = ['label' => 'Текст', 'url' => ['text/view', 'id' => $id_text]];

?>

<div>
	
	<h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

	    <?= $form->field($model, 'file_ru')->fileInput()->hint('Выберите файл с русскими фразами') ?>

	    <?= $form->field($model, 'file_engl')->fileInput()->hint('Выберите файл с английскими фразами') ?>

	    <?= $form->field($model, 'id_text')->hiddenInput(['value' => $id_text])->label(false) ?>

	    <div class="form-group">
	        <?= Html::submitButton('Добавить фразы', ['class' => 'btn btn-success']) ?>
	    </div>

    <?php ActiveForm::end(); ?>

</div>