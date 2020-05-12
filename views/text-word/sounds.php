<?php 

	use yii\helpers\Html;

	$this->registerJsFile('@web/js/sounds_words.js', ['depends' => 'yii\web\YiiAsset']);

$this->title = 'Озвучка слов';
$this->params['breadcrumbs'][] = ['label' => 'Текст', 'url' => ['/text', 'id' => $id_text]];
$this->params['breadcrumbs'][] = ['label' => 'Предложения', 'url' => ['/sentense/text', 'id_text' => $id_text]];
$this->params['breadcrumbs'][] = ['label' => 'Фразы', 'url' => ['/phrase/text', 'id_text' => $id_text]];
$this->params['breadcrumbs'][] = ['label' => 'Слова', 'url' => ['index', 'id_text' => $id_text]];

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
  .statistics {
    position: fixed;
    left: 10px;
    top: 50%;
    padding: 20px;
    background: #e5e5e5;
    font-size: 20px;
  }
</style>

<?= Html::a('Начать', ['#'], ['id' => 'start', 'data-words-str' => $words_str, 'class' => 'btn btn-primary']) ?>
<?= Html::a('Остановить', ['#'], ['id' => 'stop', 'id_text' => $id_text, 'class' => 'btn btn-primary']) ?>


<div class="wrapper">
  <div id="id_item" style="display: none;"></div>
  <div class="view" id="engl">нет слова</div>
  <button id="learned" class="btn btn-success">Выучено <span>(0)</span></button>
  <div class="view" id="ru">нет слова</div>
</div>

<div class="statistics">
  <p>Всего слов:  <span id="word_all"></span></p>
  <p>Озвучено:  <span id="word_sounded"></span></p>
  <p>Осталось:  <span id="word_rest"></span></p>
</div>

