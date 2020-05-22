<?php

use yii\helpers\{Html, Url};
use yii\grid\GridView;
use app\models\{Word, WordText};
use app\models\Sound;
use app\helpers\BreadcrumbsHelper;

$this->registerJsFile('@web/js/sort_state.js', ['depends' => 'yii\web\YiiAsset']);

$this->title = 'Слова';

$this->params['breadcrumbs'] = BreadcrumbsHelper::create($text->category, false);
$this->params['breadcrumbs'][] = ['label' => $text->category->name, 'url' => ['/category/text', 'cat_id' => $text->category->id]];
$this->params['breadcrumbs'][] = ['label' => 'Текст', 'url' => ['/text/view', 'id' => $text->id]];
$this->params['breadcrumbs'][] = ['label' => 'Предложения', 'url' => ['/string/text', 'text_id' => $text->id]];
$this->params['breadcrumbs'][] = ['label' => 'Фразы', 'url' => ['/substring/text', 'text_id' => $text->id]];
$this->params['breadcrumbs'][] = $this->title;

function create_link_state($model) {
    $params = ['/word/set-state', 'id' => $model->word->id];
    $style['class'] = ($model->word->state == STATE_NOT_LEARNED) ? 'text-danger' : 'text-success';
    $name = ($model->word->state == STATE_NOT_LEARNED) ? 'не выучено' : 'выучено';
    return Html::a($name, $params, $style);
}

function create_link_voice($model) {
    if ($model->word->sound) return sprintf('<audio controls src="/sounds/%s"></audio>', $model->word->sound->filename);
    return '<span class="text-danger">нет</span>';
}

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
        <a href="<?=Url::to(['/sound/create-file', 'text_id' => $text->id, 'type' => TYPE_WORD])?>">
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
                'value' => function($model) {return create_link_state($model);}, 
            ],

            ['attribute' => 'saund', 'format' => 'raw', 'value' => function($model) {return create_link_voice($model);}], 

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
