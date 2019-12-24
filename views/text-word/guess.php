<?php

use yii\helpers\Html;
use app\models\Word;
use yii\widgets\LinkPager;

$this->title = 'Угадай';
$this->params['breadcrumbs'][] = ['label' => 'Текст', 'url' => ['/text/view', 'id' => $id_text]];
$this->params['breadcrumbs'][] = ['label' => 'Предложения', 'url' => ['/sentense', 'id_text' => $id_text]];
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .words_wrp {
        display: flex;
        justify-content: center;
    }
    .words_wrp h2 {
        font-size: 16px;
    }
    .words_wrp div {
        margin: 20px;
    }
    .words_wrp ul {
        margin: 0;
    }
</style>
<div class="text-word-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="words_wrp">
        <div class="engl_wrp">
            <h2>English</h2>
            <ul class="engl_words">
                <? foreach ($words as $item): ?>
                    <li id_word="<?=$item->id?>" onclick="get_id_eng(this);"><?=$item->word->engl?></li>
                <? endforeach; ?>
            </ul>
        </div>
        <div class="ru_wrp">
            <h2>Russian</h2>
             <ul class="ru_words">
                <? foreach ($words as $item): ?>
                    <li id_word="<?=$item->id?>" onclick="get_id_ru(this);"><?=$item->word->ru?></li>
                <? endforeach; ?>
            </ul>
        </div>
    </div> <!-- /words_wrp -->
    
    <?= LinkPager::widget(['pagination' => $pages]); ?>
    
    <script>
        let id_engl, id_ru;
        function check_word(elem, lang) {
            elem.style.color = 'blue';
            // if (id_engl) {
            //     document.querySelector('.engl_words li[id_word="' + id_engl + '"]').style.color = 'black';
            // }
            id_word = elem.getAttribute('id_word');
            lang == 'engl' ? id_engl = id_word : id_ru = id_word;
            if (!id_ru) return;
            if (id_ru != id_engl) return alert('no');
            elem.style.display = 'none';
            document.querySelector('.ru_words li[id_word="' + id_ru + '"]').style.display = 'none';
            id_engl = null;
            id_ru = null;
    }
    </script>
</div>
