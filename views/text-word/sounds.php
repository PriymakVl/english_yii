<?php 

	use yii\helpers\Html;

	$this->registerJsFile('@web/js/sounds.js', ['depends' => 'yii\web\YiiAsset']);

 ?>



<style type="text/css">
  .well {
    width: 600px;
    margin: 100px auto;
    font-size: 40px;
    text-align: center;
  }
</style>

<?= Html::a('Начать', ['#', 'data-sounds-str' => $sounds_str], ['id' => 'start', 'class' => 'btn btn-success']) ?>

<? //printf('<a href="#" class="btn btn-success" id="sounds" data-sounds-str="%s">Начать</a>', $sounds_str) ?>


<div data-sounds="<?=$sounds_str?>" id="sounds"></div>

<div class="container">
  <div class="well">
    dddddd
  </div>
</div>
