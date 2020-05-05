<?php

use yii\helpers\Html;
use app\models\Word;

$this->title = 'Учить слово';

$this->params['breadcrumbs'][] = ['label' => 'Текст', 'url' => ['/text', 'id' => $item->id_text]];
$this->params['breadcrumbs'][] = ['label' => 'Предложения', 'url' => ['/sentense/text', 'id_text' => $item->id_text]];
$this->params['breadcrumbs'][] = ['label' => 'Слова', 'url' => ['index', 'id_text' => $item->id_text]];


?>

<style type="text/css">
    h2 span{
        margin-right: 30px;
    }
    h2 span:first-child:hover {
        cursor: pointer;
    }
    .hidden {
        display: none;
    }
/*    li[translate] {
        cursor: pointer;
    }*/
    .table {
        margin-top: 30px;
    }
</style>

<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Prev', ['teach', 'id_text' => $text->id, 'index' => $index - 1], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Next', ['teach', 'id_text' => $text->id, 'index' => $index + 1], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Learned', ['state-teach', 'id' => $item->id, 'index' => $index], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Update', ['/word/update', 'id' => $item->word->id], ['class' => 'btn btn-primary']) ?>
    </p>
    
    <h2 title="<?= $item->word->ru ?>">
        <span onclick="translate_word.classList.toggle('hidden');"><?=$item->word->engl?></span>
        <span class="text-success hidden" id="translate_word"><?=$item->word->ru?></span>
        <? printf('<audio controls src="/sounds/%s"></audio>', $item->word->sound->filename); ?>
    </h2>

    <h2 id="answer" class="hidden">Перевод: </h2>

    <? if ($sentenses): ?>
        <? $num = 1; ?>
        <table class="table table-bordered table-striped table-responsive">
            <tr>
                <th>#</th>
                <th>Предложения</th>
                <th>Озвучка</th>
            </tr>
            <? foreach ($sentenses as $sentense): ?>
                <tr style="font-size: 1.2em;">
                    <td><?= $num; ?></td>
                    <td title="<?=$sentense->ru?>" ondblclick="change_text(this);" translate="<?=$sentense->ru?>"><?=$sentense->engl?></td>
                    <td>
                        <? if($sentense->sound_id): ?>
                            <? printf('<audio controls src="/sounds/%s"></audio>', $sentense->sound->filename); ?>
                        <? else: ?>
                            <span class="red">нет</span>
                        <? endif; ?>
                    </td>
                </tr>
                <? $num++; ?>
            <? endforeach; ?>
        </table>
    <? endif; ?>
</div> <!-- .container -->

<!-- js script -->
<script type="text/javascript">
function change_text(li) {
    text = li.innerText;
    translate = li.getAttribute('translate');
    li.innerText = translate;
    li.setAttribute('translate', text);
}

</script>
