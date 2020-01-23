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

    <?php 
		$items = Category::find()->select('name')->where(['status' => STATUS_ACTIVE])->asArray()->indexBy('id')->column();
		$params = ['prompt' => 'Не выбрана'];
		echo $form->field($model, 'cat_id')->dropDownList($items, $params);
	?>
    
    <?= $form->field($model, 'title')->textInput() ?>

    <?= $form->field($model, 'engl')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ru')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
