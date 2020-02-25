<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Word;
use app\models\TextWord;
use app\models\Sound;

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
        <?= Html::a('Добавить слова', ['create', 'id_text' => $id_text], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Угадай', ['guess', 'id_text' => $id_text], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Написать', ['write', 'id_text' => $id_text], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Учить', ['teach', 'id_text' => $id_text], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Создать файл для озвучки', ['/sound/create-file', 'type' => Sound::TYPE_WORD, 'text_id' => $text->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Добавить озвучку', ['/sound/add-sounds', 'type' => Sound::TYPE_WORD], ['class' => 'btn btn-primary']) ?>
    </p>

    <div class="nav-vertical">
        <i class="fas fa-graduation-cap" id="learned-page" title="выучено все"></i>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
                'filter' => [1 => 'выучено', 0 => 'не выучено']
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
