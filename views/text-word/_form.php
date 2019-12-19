<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TextWord */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="text-word-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'file_ru')->fileInput()->hint('Выберите файл с русскими словами') ?>

    <?= $form->field($model, 'file_engl')->fileInput()->hint('Выберите файл с английскими словами') ?>

    <div class="form-group">
        <?= Html::submitButton('Добавить слова', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
