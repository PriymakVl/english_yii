<?php 

	use yii\helpers\Html;

	$this->registerJsFile('@web/js/sounds_strings.js', ['depends' => 'yii\web\YiiAsset']);

$this->title = 'Озвучка фраз';

$this->params['breadcrumbs'] = BreadcrumbsHelper::create($text->category, false);
$this->params['breadcrumbs'][] = ['label' => $text->category->name, 'url' => ['/category/text', 'cat_id' => $text->category->id]];
$this->params['breadcrumbs'][] = ['label' => 'Текст', 'url' => ['/text', 'id' => $text->id]];
$this->params['breadcrumbs'][] = ['label' => 'Предложения', 'url' => ['/string/text', 'text_id' => $text->id]];
$this->params['breadcrumbs'][] = ['label' => 'Фразы', 'url' => ['text', 'text_id' => $text->id]];
$this->params['breadcrumbs'][] = ['label' => 'Слова', 'url' => ['word-text/index', 'text_id' => $text->id]];

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
  .statistics {
    position: fixed;
    left: 10px;
    top: 50%;
    padding: 20px;
    background: #e5e5e5;
    font-size: 20px;
  }
</style>

<h1>Озвучка фраз</h1>
<a href="#" id="start" data-phrases="<?= $phrases_str ?>" class="btn btn-primary">Начать</a>
<a href="#" id="stop" id_text="<?= $id_text ?>" class="btn btn-primary">Остановить</a>

<div class="wrapper">
  <div id="id_item" style="display: none;"></div>
  <div class="view" id="engl">not phrase</div>
  <!-- <button id="learned" class="btn btn-success">Выучено <span>(0)</span></button> -->
  <div class="view" id="ru">нет фразы</div>
</div>

<div class="statistics">
  <p>Всего фраз:  <span id="str_all"></span></p>
  <p>Озвучено:  <span id="str_sounded"></span></p>
  <p>Осталось:  <span id="str_rest"></span></p>
</div>

