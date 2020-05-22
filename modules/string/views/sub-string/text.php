<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Sound;
use yii\widgets\LinkPager;
use app\helpers\BreadcrumbsHelper;


/* @var $this yii\web\View */
/* @var $searchModel app\models\SentenseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Фразы';

$this->params['breadcrumbs'] = BreadcrumbsHelper::create($text->category, false);
$this->params['breadcrumbs'][] = ['label' => $text->category->name, 'url' => ['/category/text', 'cat_id' => $text->category->id]];
$this->params['breadcrumbs'][] = ['label' => 'Текст', 'url' => ['/text/view', 'id' => $text->id]];
$this->params['breadcrumbs'][] = ['label' => 'Предложения', 'url' => ['/string/text', 'text_id' => $text->id]];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = ['label' => 'Слова', 'url' => ['/text-word', 'text_id' => $text->id]];

function create_sound_player($model) {
    if (!$model->sound_id) return '<span class="red">нет</span>';
    $sound = Sound::findOne(['id' => $model->sound_id, 'status' => STATUS_ACTIVE]);
    if (!$sound) return '<span class="red">нет</span>';
    return sprintf('<audio controls src="/sounds/%s"></audio>', $sound->filename);
}
?>
<div class="sentense-index">

    <h1>Фразы текста: <?= Html::encode($text->title) ?></h1>

    <p>
         <?= Html::a('Создать файл для озвучки', ['/sound/create-file', 'type' => TYPE_SUBSTRING, 'text_id' => $text->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Добавить озвучку', ['/sound/add-sounds', 'type' => TYPE_SUBSTRING], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Добавить фразы', ['add-from-files', 'text_id' => $text->id], ['class' => 'btn btn-primary']) ?>
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

                ['attribute' => 'sound', 'format' => 'raw', 'value' => function($model) {return create_sound_player($model);}], 

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    <? else: ?>
        <div class="alert alert-warning" role="alert">
            У этого текста фраз еще нет
        </div>
    <? endif; ?>

</div>
