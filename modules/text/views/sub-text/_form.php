<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\text\models\SubText */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sub-text-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'engl')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ru')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'text_id')->textInput(['value' => $text->id, 'readonly' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
