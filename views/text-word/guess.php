<?php

use yii\helpers\Html;
use app\models\Word;

$this->title = 'Угадай';
$this->params['breadcrumbs'][] = ['label' => 'Текст', 'url' => ['/text/view', 'id' => $id_text]];
$this->params['breadcrumbs'][] = ['label' => 'Предложения', 'url' => ['/sentense', 'id_text' => $id_text]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="text-word-index">

    <h1><?= Html::encode($this->title) ?></h1>

    
    <table>
        <tr>
            <th>English</th>
            <th>Rashian</th>
        <tr>
        <? foreach ($words as $word): ?>
            <tr>
                <td id_word="<?=$word->id?>"><?=$word->engl?></td>
                <td id_word="<?=$word->id?>"><?=$word->engl?></td>
            </tr>
        <? endforeach; ?>
    </table>
    


</div>
