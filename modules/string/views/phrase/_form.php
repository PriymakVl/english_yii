<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Phrase */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="phrase-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'engl')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ru')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_text')->textInput() ?>

    <?= $form->field($model, 'id_sentense')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'soundfile')->fileInput()->label('Файл озвучки') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
