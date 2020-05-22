<?php

use yii\helpers\Html;
use app\models\Word;
use app\helpers\BreadcrumbsHelper;

$this->title = 'Учить слово';

$this->params['breadcrumbs'] = BreadcrumbsHelper::create($text->category, false);
$this->params['breadcrumbs'][] = ['label' => $text->category->name, 'url' => ['/category/text', 'cat_id' => $text->category->id]];
$this->params['breadcrumbs'][] = ['label' => 'Текст', 'url' => ['/text/view', 'id' => $text->id]];
$this->params['breadcrumbs'][] = ['label' => 'Предложения', 'url' => ['/string/text', 'text_id' => $text->id]];
$this->params['breadcrumbs'][] = ['label' => 'Фразы', 'url' => ['/substring/text', 'text_id' => $text->id]];
$this->params['breadcrumbs'][] = ['label' => 'Слова', 'url' => ['index', 'text_id' => $text->id]];

$words_all = count($words);
$words_passed = $index;
$words_rest = $words_all - $words_passed;

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
    .table {
        margin-top: 30px;
    }
    .fa-globe-americas:hover {
        color: red;
    }
</style>

<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <ul class="statistics">
        <li>Всего слов: <span><?= $words_all ?></span></li>
        <li>Пройдено слов: <span><?= $words_passed ?></span></li>
        <li>Осталось слов: <span><?= $words_rest ?></span></li>
    </ul>

    <p>
        <?= Html::a('Prev', ['teach', 'text_id' => $text->id, 'index' => $index - 1], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Next', ['teach', 'text_id' => $text->id, 'index' => $index + 1], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Learned', ['/word/set-state', 'id' => $word->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Update', ['/word/update', 'id' => $word->id], ['class' => 'btn btn-primary']) ?>
    </p>
    
    <h2 title="<?= $word->ru ?>">
        <span onclick="translate_word.classList.toggle('hidden');"><?=$word->engl?></span>
        <span class="text-success hidden" id="translate_word"><?=$word->ru?></span>
        <? printf('<audio controls src="/sounds/%s"></audio>', $word->sound->filename); ?>
    </h2>

    <h2 id="answer" class="hidden">Перевод: </h2>

    <? if ($word->substrings): ?>
        <? $num = 1; ?>
        <table class="table table-bordered table-striped table-responsive">
            <tr>
                <th>#</th>
                <th>Фразы</th>
                <th>Озвучка</th>
            </tr>
            <? foreach ($word->substrings as $substr): ?>
                <tr style="font-size: 1.2em;cursor:pointer;">
                    <td><?= $num; ?></td>
                    <td title="<?=$substr->ru?>">
                        <i class="fas fa-globe-americas" onclick="change_text(this);"></i>
                        <span><?=$substr->engl?></span>
                    </td>
                    <td>
                        <? if($substr->sound_id): ?>
                            <? printf('<audio controls src="/sounds/%s"></audio>', $substr->sound->filename); ?>
                        <? else: ?>
                            <span class="red">нет</span>
                        <? endif; ?>
                    </td>
                </tr>
                <? $num++; ?>
            <? endforeach; ?>
        </table>
    <? endif; ?>

    <? if ($word->strings): ?>
        <? $num = 1; ?>
        <table class="table table-bordered table-striped table-responsive">
            <tr>
                <th>#</th>
                <th>Предложения</th>
                <th>Озвучка</th>
            </tr>
            <? foreach ($word->strings as $str): ?>
                <tr style="font-size: 1.2em;cursor:pointer;">
                    <td><?= $num; ?></td>
                    <td title="<?=$str->ru?>">
                         <i class="fas fa-globe-americas" onclick="change_text(this);"></i>
                        <span><?=$str->engl?></span>
                    </td>
                    <td>
                        <? if($str->sound_id): ?>
                            <? printf('<audio controls src="/sounds/%s"></audio>', $str->sound->filename); ?>
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
function change_text(icon) {
    let parent = icon.parentNode;
    text = parent.innerText;
    translate = parent.getAttribute('title');
    parent.children[1].innerText = translate;
    parent.setAttribute('title', text);
}

</script>
