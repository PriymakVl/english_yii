<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Sound;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SentenseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Предложения';

$this->params['breadcrumbs'][] = ['label' => 'Текст', 'url' => ['/text/view', 'id' => $text->id]];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = ['label' => 'Слова', 'url' => ['/text-word', 'id_text' => $text->id]];
?>
<div class="sentense-index">

    <h1><?= Html::encode($text->title) ?></h1>
    <p>
        <?= Html::a('Выровнять ru', ['align', 'text_id' => $sentenses[0]->id_text, 'lang' => 'ru'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Выровнять engl', ['align', 'text_id' => $sentenses[0]->id_text, 'lang' => 'engl'], ['class' => 'btn btn-primary']) ?>
         <?= Html::a('Создать файл для озвучки', ['/sound/create-file', 'type' => Sound::TYPE_SENTENSE, 'text_id' => $text->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Добавить озвучку', ['/sound/add-sounds', 'type' => Sound::TYPE_SENTENSE], ['class' => 'btn btn-primary']) ?>
    </p>

    <table  class="table table-bordered table-striped">
        <tr>
            <th>№</th>
            <th>Английский</th>
            <th>Озвучка</th>
            <th>Русский</th>
        </tr>
        <? $number = 1; ?>
        <? foreach ($sentenses as $sentense): ?>
            <tr>
                <td>
                    <?= Html::a($number, ['sentense/view', 'id_text' => $text->id, 'id' => $sentense->id]) ?>
                </td>
                <td><?=$sentense->engl?></td>
                <td><? debug($sentense->sound_id, false); ?></td>
                <td><?=$sentense->ru?></td>
            </tr>
            <? $number++; ?>
        <? endforeach; ?>
    </table>



</div>
