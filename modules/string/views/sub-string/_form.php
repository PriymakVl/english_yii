<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Phrase */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="phrase-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'engl')->textarea(['rows' => '3']) ?>

    <?= $form->field($model, 'ru')->textarea(['rows' => '3']) ?>

    <?= $form->field($model, 'text_id')->hiddenInput(['value' => $model->text_id])->label(false); ?>

    <?= $form->field($model, 'sound_file')->fileInput()->label('Файл озвучки') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
