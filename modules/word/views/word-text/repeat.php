<?php 

	use yii\helpers\Html;

	$this->registerJsFile('@web/js/repeat_words.js', ['depends' => 'yii\web\YiiAsset']);

$this->title = 'Повторение слов';
$this->params['breadcrumbs'][] = ['label' => 'Текст', 'url' => ['/text', 'id' => $text_id]];
$this->params['breadcrumbs'][] = ['label' => 'Предложения', 'url' => ['/sentense/text', 'id_text' => $text_id]];
$this->params['breadcrumbs'][] = ['label' => 'Фразы', 'url' => ['/phrase/text', 'id_text' => $text_id]];
$this->params['breadcrumbs'][] = ['label' => 'Слова', 'url' => ['index', 'id_text' => $text_id]];

 ?>

<style type="text/css">
  .wrapper {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
  }

  .card {
    width: 260px;
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
      text-align: center;
      font-size: 24px;
      text-transform: capitalize;
  }
  .card__content:hover {
    text-decoration: underline;
  }
  .card__action {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
  .card__delete:hover, .card__play:hover {
    color: red;
  }
</style>

<a href="#" id="turn_ru" class = "btn btn-primary">Russian</a>
<a href="#" id="turn_engl" class = "btn btn-primary">English</a>


<div class="wrapper">
  <? if ($items): ?>
    <?php foreach ($items as $item): ?>
      <div class="card" sound="<?= $item->word->sound->filename ?>">
        <div class="card__content" ru="<?= $item->word->ru ?>" engl="<?= $item->word->engl ?>" >
          <?= $item->word->engl ?>
        </div>
        <div class="card__action">
          <i class="far fa-trash-alt card__delete"></i>
          <i class="fas fa-play-circle card__play"></i>
        </div>
      </div>
    <?php endforeach ?>
  <? else: ?>
    <div class="alert alert-warning" role="alert">
      Слов нет
    </div>
  <? endif; ?>
</div>

