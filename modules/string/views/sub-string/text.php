<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Sound;
use yii\widgets\LinkPager;
use app\helpers\BreadcrumbsHelper;

$this->title = 'Фразы';

$bc_cat = BreadcrumbsHelper::category($text->category);
$bc_text = BreadcrumbsHelper::text($text->id);
$this->params['breadcrumbs'] = array_merge($bc_cat, ['.......'], $bc_text);

function create_sound_player($model) {
    if (!$model->sound_id) return '<span class="red">нет</span>';
    $sound = Sound::findOne(['id' => $model->sound_id, 'status' => STATUS_ACTIVE]);
    if (!$sound) return '<span class="red">нет</span>';
    return sprintf('<audio controls src="/sounds/%s"></audio>', $sound->filename);
}
?>
<div class="substring-index">

    <h4><b>Текст:</b> <?= $text->title ?></h4>
    <h1> <?= Html::encode($this->title) ?></h1>

     <ul class="statistics">
        <li>Всего фраз: <span><?= $text->statistics['all'] ?></span></li>
        <li>Выучено фраз: <span><?= $text->statistics['learned'] ?></span></li>
        <li>Не выучено фраз: <span><?= $text->statistics['not_learned'] ?></span></li>
    </ul>

    <p>
         <?= Html::a('Создать файл для озвучки', ['/sound/create-file-strings', 'type' => TYPE_SUBSTRING, 'text_id' => $text->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Добавить озвучку', ['/sound/add-sounds', 'type' => TYPE_SUBSTRING], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Озвучить', ['sounds', 'text_id' => $text->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Повторять', ['repeat', 'text_id' => $text->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <? if ($dataProvider->getModels()): ?>
        
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'engl',

                'ru',

                ['attribute' => 'sound', 'format' => 'raw', 'value' => function($model) {return $model->getSoundPlayer();}],  

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    <? else: ?>
        <div class="alert alert-warning" role="alert">
            У этого текста предложений еще нет
        </div>
    <? endif; ?>

</div>
