<?php 

	use yii\helpers\Html;

	$this->registerJsFile('@web/js/sounds_words.js', ['depends' => 'yii\web\YiiAsset']);

$this->title = 'Озвучка слов';

$this->params['breadcrumbs'] = BreadcrumbsHelper::create($text->category, false);
$this->params['breadcrumbs'][] = ['label' => $text->category->name, 'url' => ['/category/text', 'cat_id' => $text->category->id]];
$this->params['breadcrumbs'][] = ['label' => 'Текст', 'url' => ['/text', 'id' => $text->id]];
$this->params['breadcrumbs'][] = ['label' => 'Предложения', 'url' => ['/string/text', 'text_id' => $text->id]];
$this->params['breadcrumbs'][] = ['label' => 'Фразы', 'url' => ['/substring/text', 'text_id' => $text->id]];
$this->params['breadcrumbs'][] = ['label' => 'Слова', 'url' => ['index', 'text_id' => $text->id]];

 ?>



<style type="text/css">
  .view {
    width: 600px;
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
  .statistics_sounds {
    position: fixed;
    left: 10px;
    top: 50%;
    padding: 20px;
    background: #e5e5e5;
    font-size: 20px;
  }
</style>

<?= Html::a('Начать', ['#'], ['id' => 'start', 'data-sounds-str' => $sounds_str, 'class' => 'btn btn-primary']) ?>
<?= Html::a('Остановить', ['#'], ['id' => 'stop', 'text_id' => $text->id, 'class' => 'btn btn-primary']) ?>


<div class="wrapper">
  <div id="id_item" style="display: none;"></div>
  <div class="view" id="engl">нет слова</div>
  <button id="learned" class="btn btn-success">Выучено <span>(0)</span></button>
  <div class="view" id="ru">нет слова</div>
</div>

<div class="statistics_sounds">
  <p>Всего слов:  <span id="word_all"></span></p>
  <p>Озвучено:  <span id="word_sounded"></span></p>
  <p>Осталось:  <span id="word_rest"></span></p>
</div>

