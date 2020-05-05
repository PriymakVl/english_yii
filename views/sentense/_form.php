<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Sentense */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sentense-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'engl')->textarea(['rows' => '3']) ?>

    <?= $form->field($model, 'ru')->textarea(['rows' => '3']) ?>

    <?= $form->field($model, 'id_text')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'soundfile')->fileInput()->label('Файл озвучки') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

