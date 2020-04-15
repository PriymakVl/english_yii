<?php 

	use yii\helpers\Html;

	$this->registerJsFile('@web/js/sounds.js', ['depends' => 'yii\web\YiiAsset']);

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
</style>

<?= Html::a('Начать', ['#'], ['id' => 'start', 'data-words-str' => $words_str, 'class' => 'btn btn-primary']) ?>
<?= Html::a('Остановить', ['#'], ['id' => 'stop', 'id_text' => $id_text, 'class' => 'btn btn-primary']) ?>


<div class="wrapper">
  <div id="id_item" style="display: none;"></div>
  <div class="view" id="engl">нет слова</div>
  <button id="learned" class="btn btn-success">Выучено <span>(0)</span></button>
  <div class="view" id="ru">нет слова</div>
</div>