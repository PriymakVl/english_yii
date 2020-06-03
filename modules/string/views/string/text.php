<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Sound;
use yii\widgets\LinkPager;
use app\helpers\BreadcrumbsHelper;

$this->title = 'Предложения';

$bc_cat = BreadcrumbsHelper::category($text->category);
$bc_text = BreadcrumbsHelper::text($text->id);
$this->params['breadcrumbs'] = array_merge($bc_cat, ['...'], $bc_text);

?>
<div class="string-index">

    <h4><b>Текст:</b> <?= $text->title ?></h4>
    <h1> <?= Html::encode($this->title) ?></h1>

     <ul class="statistics">
        <li>Всего предложений: <span><?= $text->statistics['all'] ?></span></li>
        <li>Выучено предложений: <span><?= $text->statistics['learned'] ?></span></li>
        <li>Не выучено предложений: <span><?= $text->statistics['not_learned'] ?></span></li>
    </ul>

    <p>
        <?= Html::a('Разбить абзацы  на предложения', ['break-sub-text', 'text_id' => $text->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Создать файл для озвучки', ['/sound/create-file-strings', 'type' => TYPE_STRING, 'text_id' => $text->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Добавить озвучку', ['/sound/add-sounds', 'type' => TYPE_STRING], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Добавить фразы', ['add-from-files', 'text_id' => $text->id], ['class' => 'btn btn-primary']) ?>
    </p>
    <p>
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

                ['value' => function($model) {return $model->substrings ? '<span class="green">есть</span>' : '<span class="red">нет</span>';},
                'label' => 'Фразы', 'format' => 'raw'], 

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
