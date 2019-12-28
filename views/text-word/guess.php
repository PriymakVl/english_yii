<?php

use yii\helpers\Html;
use app\models\Word;
use yii\widgets\LinkPager;

$this->title = 'Угадай';
$this->params['breadcrumbs'][] = ['label' => 'Текст', 'url' => ['/text/view', 'id' => $text->id]];
$this->params['breadcrumbs'][] = ['label' => 'Предложения', 'url' => ['/sentense', 'id_text' => $text->id]];
$this->params['breadcrumbs'][] = ['label' => 'Слова', 'url' => ['/text-word', 'id_text' => $text->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .words_wrp {
        display: flex;
        justify-content: center;
    }
    .words_wrp h2 {
        font-size: 20px;
        text-transform: uppercase;
    }
    .words_wrp div {
        margin-right: 100px;
    }
    .words_wrp ul {
        margin-left: -25px;
    }

    .words_wrp li {
        font-size: 16px;
        margin-bottom: 10px;
        font-weight: 700;
    }

    .words_wrp li:hover {
        cursor: pointer;
        text-decoration: underline;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 30px;
    }
</style>

<div class="text-word-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="words_wrp">
        <div class="engl_wrp">
            <h2>English</h2>
            <ul class="engl_words">
                <? foreach ($engl as $item): ?>
                    <li id_word="<?=$item->id?>" onclick="get_id_eng(this);"><?=$item->word->engl?></li>
                <? endforeach; ?>
            </ul>
        </div>
        <div class="ru_wrp">
            <h2>Russian</h2>
             <ul class="ru_words">
                <? foreach ($ru as $item): ?>
                    <li id_word="<?=$item->id?>" onclick="get_id_ru(this);"><?=$item->word->ru?></li>
                <? endforeach; ?>
            </ul>
        </div>
    </div> <!-- /words_wrp -->
    
    <?= LinkPager::widget(['pagination' => $pages]); ?>
    
<script>
    let id_engl, id_ru;

    function get_id_eng(elem) {
        elem.style.color = 'blue';
        if (id_engl) {
            document.querySelector('.engl_words li[id_word="' + id_engl + '"]').style.color = 'black';
        }
        id_engl = elem.getAttribute('id_word');
        if (!id_ru) return;
        if (id_ru != id_engl) return add_error(id_engl);
        elem.style.display = 'none';
        document.querySelector('.ru_words li[id_word="' + id_ru + '"]').style.display = 'none';
        show_errors();
        id_engl = null;
        id_ru = null;
    }

    function get_id_ru(elem) {
        elem.style.color = 'blue';
        if (id_ru) {
            let res = document.querySelector('.ru_words li[id_word="' + id_ru + '"]').style.color = 'black';
        }
        id_ru = elem.getAttribute('id_word');
        if (!id_engl) return;
        if (id_ru != id_engl) return add_error(id_engl);
        elem.style.display = 'none';
        document.querySelector('.engl_words li[id_word="' + id_engl + '"]').style.display = 'none';
        show_errors();
        id_engl = null;
        id_ru = null;
    }

    function add_error(id_word)
    {
        let engl = $('.engl_words li[id_word="' + id_word + '"]').text();
        let ru = $('.ru_words li[id_word="' + id_word + '"]').text();
        let error = id_word + ',' + engl + ',' + ru;
        document.cookie = document.cookie + ':' + error;
        // let errors = Cookies.get('errors');
        // console.log(document.cookie);
        alert('no');
    }

    function show_errors() {
        let check_empty = $('.engl_words li:visible').length;
        if (check_empty != 0) return;
        let errors = document.cookie.split(':');
        console.log(errors);
    }

    document.cookie = '';
</script>
</div>
