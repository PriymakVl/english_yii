<?php 

	use yii\helpers\Html;

	$this->registerJsFile('@web/js/sounds_phrases.js', ['depends' => 'yii\web\YiiAsset']);

$this->title = 'Озвучка фраз';
$this->params['breadcrumbs'][] = ['label' => 'Текст', 'url' => ['/text', 'id' => $id_text]];
$this->params['breadcrumbs'][] = ['label' => 'Предложения', 'url' => ['/sentense/text', 'id_text' => $id_text]];
$this->params['breadcrumbs'][] = ['label' => 'Фразы', 'url' => ['text', 'id_text' => $id_text]];
$this->params['breadcrumbs'][] = ['label' => 'Слова', 'url' => ['text-word/text', 'id_text' => $id_text]];

 ?>



<style type="text/css">
  .view {
    width: 950px;
    margin: 50px auto;
    font-size: 40px;
    text-align: center;
    background: #d3d3d3;
    display: none;
    padding: 50px 0;
  }
  #stop {
    display: none;
  }
  #learned {
    position: fixed;
    top: 50%;
    right: 100px;
  }
</style>

<a href="#" id="start" data-phrases="<?= $phrases_str ?>" class="btn btn-primary">Начать</a>
<a href="#" id="stop" id_text="<?= $id_text ?>" class="btn btn-primary">Остановить</a>

<div class="wrapper">
  <div id="id_item" style="display: none;"></div>
  <div class="view" id="engl">not phrase</div>
  <!-- <button id="learned" class="btn btn-success">Выучено <span>(0)</span></button> -->
  <div class="view" id="ru">нет фразы</div>
</div>
