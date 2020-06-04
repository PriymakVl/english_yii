<?php 

use yii\helpers\Html;
use app\helpers\BreadcrumbsHelper;

$this->registerJsFile('@web/js/repeat_cards.js', ['depends' => 'yii\web\YiiAsset']);

$this->title = 'Повторение слов';

$bc_cat = BreadcrumbsHelper::category($text->category);
$bc_text = BreadcrumbsHelper::text($text->id);
$this->params['breadcrumbs'] = array_merge($bc_cat, ['...'], $bc_text);

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
      width: 90%;
      text-align: center;
      font-size: 24px;
      text-transform: capitalize;
  }
  .card__content span:hover {
    text-decoration: underline;
  }
  .card__action {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
  }
  .card__action .fas:hover  {
    color: red;
  }
</style>

<button id="turn_lang" class="btn btn-primary">Russion</button>


<div class="wrapper">
  <? if ($words): ?>
    <?php foreach ($words as $word): ?>
      <div class="card">
        <div class="card__content" >
          <span title="<?=$word->ru?>"><?= $word->engl ?></span>
        </div>
        <div class="card__action">
          <i class="fas fa-eye-slash card__hide" title="не показывать"></i>
          <i class="fas fa-check-circle card__learned" word_id="<?=$word->id?>" title="выучено"></i>
          <i class="fas fa-play-circle card__play" onclick="sound_play(this);" sound="<?= $word->sound->filename ?>" title="озвучить"></i>
        </div>
      </div>
    <?php endforeach ?>
  <? else: ?>
    <div class="alert alert-warning" role="alert">
      Слов нет
    </div>
  <? endif; ?>
</div>

