<?php

use yii\helpers\Html;
use app\models\Word;

$this->title = 'Правописание';

$this->params['breadcrumbs'][] = ['label' => 'Текст', 'url' => ['/text', 'id' => $item->id_text]];
$this->params['breadcrumbs'][] = ['label' => 'Предложения', 'url' => ['/sentense', 'id_text' => $item->id_text]];
$this->params['breadcrumbs'][] = ['label' => 'Слова', 'url' => ['index', 'id_text' => $item->id_text]];


?>

<style type="text/css">
    #answer {
        display: none;
    }
    label[for="word"] {
        font-size: 20px;
    }
</style>

<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Предыдущее', ['write', 'id_text' => $item->id_text, 'index' => $index - 1], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('следущее', ['write', 'id_text' => $item->id_text, 'index' => $index + 1], ['class' => 'btn btn-primary']) ?>
    </p>

    <div class="form-group">
        <label for="word"><?=$item->word->ru?>:</label>
        <input type="text" class="form-control" id="word" autofocus>
    </div>

    <a href="#" onclick="check_write(this);" index="<?=$index?>" id_text="<?=$text->id?>" engl="<?=$item->word->engl?>" id="check">Проверить</a>
    <a href="#" id="show" onclick="answer.style.display='block'">Показать</a>

    <h2 id="answer">Правильно: <span class="text-success"><?=$item->word->engl?></span></h2>

</div>

<!-- js script -->
<script type="text/javascript">
function check_write(obj) {
    let engl = obj.getAttribute('engl');
    let engl_write = word.value;
    if (engl != engl_write) return alert('Неправильно');
    let index = obj.getAttribute('index');
    index = parseInt(index) + 1;
    let id_text = obj.getAttribute('id_text');
    location.href = '/text-word/write?id_text=' + id_text + '&index=' + index; 
} 

(function() {
document.querySelector('input').addEventListener('keydown', function(e) {
        if (e.keyCode === 13) check_write(check);
        else if (e.keyCode === 16) answer.style.display="block";
    });
})();
</script>
