<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Добавить слова для текста';

$this->params['breadcrumbs'][] = ['label' => 'Текст', 'url' => ['/text/view', 'id' => $text_id]];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="word-text-form">

	<h1><?= $this->title ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    	<?= $form->field($model, 'file_ru')->fileInput()->hint('Выберите файл с русскими словами') ?>

    	<?= $form->field($model, 'file_engl')->fileInput()->hint('Выберите файл с английскими словами') ?>

    	<?= $form->field($model, 'text_id')->hiddenInput(['value' => $text_id])->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton('Добавить слова', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
