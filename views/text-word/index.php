<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\models\Word;
use app\models\TextWord;
use app\models\Sound;

$page = Yii::$app->request->get('page');

$this->title = 'Слова';
$this->params['breadcrumbs'][] = ['label' => 'Текст', 'url' => ['/text/view', 'id' => $text->id]];
$this->params['breadcrumbs'][] = ['label' => 'Предложения', 'url' => ['/sentense', 'id_text' => $text->id]];
$this->params['breadcrumbs'][] = $this->title;

function create_link_state($item) {
    $page = Yii::$app->request->get('page');
    $params = ['text-word/state-index', 'id' => $item->id, 'page' => $page ? $page : 1];
    $params['state'] = $item->state == TextWord::STATE_NOT_LEARNED ? 1 : 0;
    $style['class'] = $item->state == TextWord::STATE_NOT_LEARNED ? 'text-danger' : 'text-success';
    $name = $item->state == TextWord::STATE_NOT_LEARNED ? 'не выучено' : 'выучено';
    return Html::a($name, $params, $style);
}

function create_link_update($item)
{
    $page = Yii::$app->request->get('page');
    $icon = '<span class="glyphicon glyphicon-pencil"></span>';
    $params = ['/text-word/before-update', 'id' => $item->id, 'page' => $page];
    return Html::a($icon, $params);
}

function create_link_delete($item) {
    $page = Yii::$app->request->get('page');
    $icon = '<span class="glyphicon glyphicon-trash"></span>';
    $params = ['/text-word/delete', 'id' => $item->id, 'page' => $page];
    $options['data']['confirm'] = 'Вы действительно хотите удалить это слово?';
    $options['data']['method'] = ['post'];
    return Html::a($icon, $params, $options);
}

function create_link_voice($model) {
    // return '<i class="fas fa-volume-up"></i>';
    if (!$model->word->sound_id) return 'нет';
    $sound = Sound::findOne(['id' => $model->word->sound_id, 'status' => STATUS_ACTIVE]);
    if (!$sound) return 'нет';
    return sprintf('<audio controls src="/sounds/%s"></audio>', $sound->filename);
}
?>
<div class="text-word-index">

    <h1><?= Html::encode($text->title) ?></h1>

    <p class="nav-horizontal">
        <?= Html::a('Угадай', ['guess', 'id_text' => $text->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Написать', ['write', 'id_text' => $text->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Учить', ['teach', 'id_text' => $text->id], ['class' => 'btn btn-primary']) ?>
        <?//= Html::a('Озвучить', ['#'], ['class' => 'btn btn-primary', 'id' => 'words-sound' 'sounds' => TextWord::getSoundFiles()]) ?>
    </p>

    <div class="nav-vertical">
        <a href="/text-word/state-page?id_text=<?=$text->id?>&page=<?=$page?>">
            <i class="fas fa-graduation-cap" title="выучено все"></i>
        </a>
        <a href="<?=Url::to(['/sound/create-file', 'text_id' => $text->id, 'type' => Sound::TYPE_WORD])?>">
            <i class="fas fa-file-audio" title="создать файл озвучки"></i>
        </a>
        <a href="<?=Url::to(['/sound/add-sounds', 'type' => Sound::TYPE_WORD])?>">
            <i class="fas fa-microphone-alt" title="добавить озвучку"></i>
        </a>
        <a href="<?=Url::to(['create', 'id_text' => $text->id])?>">
            <i class="fas fa-plus-circle" title="добваит слова"></i>
        </a>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute' => 'engl', 'label' => 'Английские', 'format' => 'raw',
                'value' => function($model) {return Word::findOne($model->id_word)->engl;}, 
            ],

            ['attribute' => 'engl', 'label' => 'Русские', 'format' => 'raw',
                'value' => function($model) {return Word::findOne($model->id_word)->ru;}, 
            ],

            ['attribute' => 'state', 'label' => 'Состояние', 'format' => 'raw',
                'value' => function($model) {return create_link_state($model);}, 
                'filter' => ['' => 'все', 1 => 'выучено', 0 => 'не выучено']
            ],

            ['attribute' => 'saund', 'format' => 'raw', 'value' => function($model) {return create_link_voice($model);}],

            ['class' => 'yii\grid\ActionColumn', 'contentOptions' => ['style' => 'width:100px; text-align:center;'],

                'headerOptions' => ['class' => 'text-info'], 'header' => 'Операции', 'template' => '{view} {update} {delete}', 
                'buttons' => [
                    'update' => function ($url, $model) { return create_link_update($model);},

                    'delete' => function ($url, $model) { return create_link_delete($model);}
                ],

            ],  


            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
