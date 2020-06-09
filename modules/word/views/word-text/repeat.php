<?php 

use yii\helpers\Html;
use app\helpers\BreadcrumbsHelper;
use app\models\Sound;

$this->registerJsFile('@web/js/repeat_cards.js', ['depends' => 'yii\web\YiiAsset']);
$this->registerJsFile('@web/js/select_subtext.js', ['depends' => 'yii\web\YiiAsset']);

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
    width: 20%;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-content: space-between;
  }
  .card__action .fas:hover  {
    color: red;
  }

  .modal-body h3 {
    position: relative;
  }

  .modal-body .player-btn {
    position: absolute;
    top: 1px;
    right: 0;
    font-size: 22px;
  }

  .modal-body h3:hover {
    cursor: pointer;
    background: #ccc;
  }
</style>

<button id="turn_lang" class="btn btn-primary">Russion</button>

<label for="subtext">№ абзаца: </label>
<select name="subtext" id="subtext">
  <option value="">Все</option>
  <?php foreach ($text->subtexts as $subtext): ?>
    <option value="<?= $subtext->id ?>" <?= $subtext->id == $subtext_id ? 'selected' : '' ?>><?= $subtext->number ?></option>
  <?php endforeach ?>
</select>

<span>Количество слов: <?= count($words) ?></span>


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
          <?php if ($word->substrings): ?>
             <i class="fas fa-quote-right" engl="<?= $word->engl ?>" ru="<?= $word->ru ?>" onclick="showPhrases(this);" data-phrases="<?=Sound::createSoundsString($word->substrings);?>" title="фразы"></i>
          <?php endif ?>
        </div>
      </div>
    <?php endforeach ?>
  <? else: ?>
    <div class="alert alert-warning" role="alert">
      Слов нет
    </div>
  <? endif; ?>
</div>

<!-- HTML-код модального окна -->
<div id="myModalBox" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Заголовок модального окна -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title"></h4>
      </div>
      <!-- Основное содержимое модального окна -->
      <div class="modal-body"></div>
    </div>
  </div>
</div>

<script>
  function showPhrases(elem)
  {
    let phrases_str = $(elem).data('phrases');

    phrases_arr = phrases_str.split(';');
    phrases_list = '';

    for (let i = 0; i < phrases_arr.length; i++) {
      item = phrases_arr[i].split(':');
      if (item[1] == undefined) continue;
      phrases_list += '<h3 title="' + item[2] + '">' + item[1];
      phrases_list += '<i class="fas fa-play-circle player-btn" onclick="sound_play(this);" sound="' + item[0] + '"></i>';
      phrases_list += '</h3>';
    }
    let engl = $(elem).attr('engl');
    let ru = $(elem).attr('ru');
    $('.modal-title').text(engl + ' (' + ru + ')');
    $('.modal-body').html(phrases_list);
    $('#myModalBox').modal('show');
  }
</script>

