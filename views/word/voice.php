<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Добавление звуковых файлов';
$this->params['breadcrumbs'][] = ['label' => 'Words', 'url' => ['index']];
\yii\web\YiiAsset::register($this);

?>
<?= Html::a('Создать файл', ['create-file'], ['class' => 'btn btn-primary']) ?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="word-voice-form">

    <?php $form = ActiveForm::begin(); ?>

	<?php 

		$items = ['word' => 'Слова', 'sentense' => 'Предложения'];
		$params = ['prompt' => 'Не выбран'];

		echo $form->field($model, 'voice')->dropDownList($items, $params);

	?>

    <div class="form-group">
        <?= Html::submitButton('Добавить звуковые файлы', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
