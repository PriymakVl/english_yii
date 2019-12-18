<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TextWord */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="text-word-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_text')->textInput() ?>

    <?= $form->field($model, 'id_word')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
