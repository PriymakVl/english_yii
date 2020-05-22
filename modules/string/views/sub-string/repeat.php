<?php 

	use yii\helpers\Html;
  use app\helpers\BreadcrumbsHelper;

	$this->registerJsFile('@web/js/repeat_cards.js', ['depends' => 'yii\web\YiiAsset']);

$this->title = 'Повторение фраз';

$this->params['breadcrumbs'] = BreadcrumbsHelper::create($text->category, false);
$this->params['breadcrumbs'][] = ['label' => $text->category->name, 'url' => ['/category/text', 'cat_id' => $text->category->id]];
$this->params['breadcrumbs'][] = ['label' => 'Текст', 'url' => ['/text/view', 'id' => $text->id]];
$this->params['breadcrumbs'][] = ['label' => 'Предложения', 'url' => ['/string/text', 'text_id' => $text->id]];
$this->params['breadcrumbs'][] = ['label' => 'Фразы', 'url' => ['text', 'text_id' => $text->id]];
$this->params['breadcrumbs'][] = ['label' => 'Слова', 'url' => ['/word-text', 'text_id' => $text->id]];

 ?>

<style type="text/css">
  .wrapper {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
  }

  .card {
    width: 550px;
    margin: 10px 0;
    padding: 10px;
    background: #d3d3d3;
    display: flex;
  }
  .card:hover {
    cursor: pointer;
  }
  .card__content {
      width: 95%;
      font-size: 20px;
  }
  .card__content:hover {
    text-decoration: underline;
  }
  .card__action {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
  .card__action i:first-child {
    margin-bottom: 5px;
  }
  .card__delete:hover, .card__play:hover {
    color: red;
  }
</style>
<h1>Повторение фраз</h1>
<button id="turn_lang" class="btn btn-primary">Russion</button>

<div class="wrapper">
  <? if ($substrings): ?>
    <?php foreach ($substrings as $substr): ?>
      <div class="card">
        <div class="card__content" >
          <span title="<?=$substr->ru?>"><?= $substr->engl ?></span>
        </div>
        <div class="card__action">
          <i class="fas fa-eye-slash card__hide" title="не показывать"></i>
          <i class="fas fa-play-circle card__play" sound="<?= $substr->sound->filename ?>"></i>
        </div>
      </div>
    <?php endforeach ?>
  <? else: ?>
    <div class="alert alert-warning" role="alert">
      Слов нет
    </div>
  <? endif; ?>
</div>

