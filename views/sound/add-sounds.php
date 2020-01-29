<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Sound;

$this->title = 'Добавить звуковые файлы';
$this->params['breadcrumbs'][] = ['label' => 'Слова', 'url' => ['/word']];
\yii\web\YiiAsset::register($this);

?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="file-voice-form">

    <?php $form = ActiveForm::begin(); ?>

		<?php 
			$items = [Sound::TYPE_WORD => 'Слова', Sound::TYPE_SENTENSE => 'Предложения'];
			$params = ['prompt' => 'Не выбран'];

			echo $form->field($model, 'type')->dropDownList($items, $params);
		?>

		
	    <div class="form-group">
	        <?= Html::submitButton('Добавить звуковые файлы', ['class' => 'btn btn-success']) ?>
	    </div>

    <?php ActiveForm::end(); ?>

</div>
