<?php

use yii\helpers\{Html, Url};
use yii\grid\GridView;
use app\models\{Word, WordText};
use app\models\Sound;
use app\helpers\BreadcrumbsHelper;

$this->registerJsFile('@web/js/sort_state.js', ['depends' => 'yii\web\YiiAsset']);

$this->title = 'Слова';

$bc_cat = BreadcrumbsHelper::category($text->category);
$bc_text = BreadcrumbsHelper::text($text->id);
$this->params['breadcrumbs'] = array_merge($bc_cat, ['...'], $bc_text);

?>

<div class="text-word-index">

    <h1><?= Html::encode($text->title) ?></h1>

    <ul class="statistics">
        <li>Всего слов: <span><?= $text->statistics['all'] ?></span></li>
        <li>Выучено слов: <span><?= $text->statistics['learned'] ?></span></li>
        <li>Не выучено слов: <span><?= $text->statistics['not_learned'] ?></span></li>
    </ul>

    <p class="nav-horizontal">
        <?= Html::a('Угадай', ['guess', 'text_id' => $text->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Написать', ['write', 'text_id' => $text->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Учить', ['teach', 'text_id' => $text->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Озвучить', ['sounds', 'text_id' => $text->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Повторять', ['repeat', 'text_id' => $text->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <div class="nav-vertical">
        <a href="/text-word/state-page?text_id=<?=$text->id?>&page=<?=$page?>">
            <i class="fas fa-graduation-cap" title="выучено все"></i>
        </a>
        <a href="<?=Url::to(['/sound/create-file-strings', 'text_id' => $text->id, 'type' => TYPE_WORD])?>">
            <i class="fas fa-file-audio" title="создать файл озвучки"></i>
        </a>
        <a href="<?=Url::to(['/sound/add-sounds', 'type' => TYPE_WORD])?>">
            <i class="fas fa-microphone-alt" title="добавить озвучку"></i>
        </a>
        <a href="<?=Url::to(['/word-text/add-from-files', 'text_id' => $text->id])?>">
            <i class="fas fa-plus-circle" title="добавить слова"></i>
        </a>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute' => 'engl', 'label' => 'Английские', 'format' => 'raw',
                'value' => function($model) {return $model->word->engl;}, 
            ],

            ['attribute' => 'ru', 'label' => 'Русские', 'format' => 'raw',
                'value' => function($model) {return $model->word->ru;}, 
            ],

            ['attribute' => 'state', 'label' => 'Состояние', 'format' => 'raw',
                'value' => function($model) {return $model->word->templateLinkState();}, 
            ],
 
            ['attribute' => 'sound', 'format' => 'raw', 'value' => function($model) {return $model->word->getSoundPlayer();}], 

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
