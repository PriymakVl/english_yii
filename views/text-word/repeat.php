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

  .card__delete:hover {
    color: red;
  }

</style>

<?//= Html::a('Начать', ['#'], ['id' => 'start', 'data-words-str' => $words_str, 'class' => 'btn btn-primary']) ?>


<div class="wrapper">
  <? if ($items): ?>
    <?php foreach ($items as $item): ?>
      <div class="card" >
        <div class="card__content" ru="<?= $item->word->ru ?>" engl="<?= $item->word->engl ?>" sound="<?= $item->word->sound->filename ?>">
          <?= $item->word->engl ?>
        </div>
        <i class="far fa-trash-alt card__delete"></i>
      </div>
    <?php endforeach ?>
  <? else: ?>
    <div class="alert alert-warning" role="alert">
      Слов нет
    </div>
  <? endif; ?>
</div>

