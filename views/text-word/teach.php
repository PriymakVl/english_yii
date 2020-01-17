<?php

use yii\helpers\Html;
use app\models\Word;

$this->title = 'Учить слово';

$this->params['breadcrumbs'][] = ['label' => 'Текст', 'url' => ['/text', 'id' => $item->id_text]];
$this->params['breadcrumbs'][] = ['label' => 'Предложения', 'url' => ['/sentense', 'id_text' => $item->id_text]];
$this->params['breadcrumbs'][] = ['label' => 'Слова', 'url' => ['index', 'id_text' => $item->id_text]];


?>

<style type="text/css">
    #answer {
        display: none;
    }
    li[translate] {
        cursor: pointer;
    }
</style>

<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Предыдущее', ['teach', 'id_text' => $text->id, 'index' => $index - 1], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Следущее', ['teach', 'id_text' => $text->id, 'index' => $index + 1], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Выучено', ['state-teach', 'id' => $item->id, 'index' => $index], ['class' => 'btn btn-primary']) ?>
    </p>
    
    <h2><?=$item->word->engl?></h2>
    <a href="#" id="show" onclick="answer.style.display='block'">Показать перевод</a>

    <h2 id="answer">Правильно: <span class="text-success"><?=$item->word->ru?></span></h2>

    <div>
        <h2>Предложения:</h2>
        <ul>
            <? foreach ($sentenses as $sentense): ?>
                <li onclick="change_text(this);" translate="<?=$sentense->ru?>"><?=$sentense->engl?></li>
            <? endforeach; ?>
        </ul>
    </div>

</div>

<!-- js script -->
<script type="text/javascript">
function change_text(li) {
    text = li.innerText;
    translate = li.getAttribute('translate');
    li.innerText = translate;
    li.setAttribute('translate', text);
}
</script>
