<?php 

	use yii\helpers\Html;
  use app\helpers\BreadcrumbsHelper;

	$this->registerJsFile('@web/js/sounds_strings.js', ['depends' => 'yii\web\YiiAsset']);

$this->title = 'Озвучка фраз';

$bc_cat = BreadcrumbsHelper::category($text->category);
$bc_text = BreadcrumbsHelper::text($text->id);
$this->params['breadcrumbs'] = array_merge($bc_cat, ['...'], $bc_text);

?>

<style type="text/css">
  h1 { text-align: center; }
  .view {
    width: 950px; margin: 50px auto; font-size: 40px; text-align: center; background: #d3d3d3; display: none;
    padding: 50px 0;
  }
  #stop {
    display: none;
  }
  #learned {
    position: fixed; top: 50%; right: 100px;
  }
</style>

<h1>Озвучка фраз</h1>
<a href="#" id="start" data-strings="<?= $sounds_str ?>" class="btn btn-primary">Начать</a>
<a href="#" id="stop" id_text="<?= $id_text ?>" class="btn btn-primary">Остановить</a>

<div class="wrapper">
  <div id="id_item" style="display: none;"></div>
  <div class="view" id="engl">not phrase</div>
  <!-- <button id="learned" class="btn btn-success">Выучено <span>(0)</span></button> -->
  <div class="view" id="ru">нет фразы</div>
</div>

<div class="statistics_sounds">
  <p>Всего фраз:  <span id="str_all"><?= count($text->substrings) ?></span></p>
  <p>Озвучено:  <span id="str_sounded">0</span></p>
  <p>Осталось:  <span id="str_rest">0</span></p>
</div>

