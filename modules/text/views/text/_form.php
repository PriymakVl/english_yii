<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Category;

/* @var $this yii\web\View */
/* @var $model app\models\Text */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="text-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cat_id')->textInput(['value' => $cat->id, 'readonly' => 'readonly'])->label('ID категории:'.$cat->name) ?>
    
    <?= $form->field($model, 'title')->textInput()->label('Заголовок') ?>

    <?= $form->field($model, 'ref')->textInput()->label('Источник') ?>

    <?= $form->field($model, 'engl')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ru')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
