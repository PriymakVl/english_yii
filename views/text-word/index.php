<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Word;
use app\models\TextWord;

$this->title = 'Слова';
$this->params['breadcrumbs'][] = ['label' => 'Текст', 'url' => ['/text/view', 'id' => $id_text]];
$this->params['breadcrumbs'][] = ['label' => 'Предложения', 'url' => ['/sentense', 'id_text' => $id_text]];
$this->params['breadcrumbs'][] = $this->title;

function setSession()
{
    $session = Yii::$app->session;
    $session->open();
    $session->set('page') = Yii::$app->request->get('page');
    $session->set('per-page') = Yii::$app->request->get('per-page');
}

function create_link_state($item) {
    setSession();
    $params = ['text-word/state-index', 'id' => $item->id];
    $params['state'] = $item->state == TextWord::STATE_NOT_LEARNED ? 1 : 0;
    $style['class'] = $item->state == TextWord::STATE_NOT_LEARNED ? 'text-danger' : 'text-success';
    $name = $item->state == TextWord::STATE_NOT_LEARNED ? 'не выучено' : 'выучено';
    return Html::a($name, $params, $style);
}

function create_link_update()
{
    setSession();
    $icon = '<span class="glyphicon glyphicon-pencil"></span>';
    $params = ['/word/updateIndex', 'id' => $model->id_word]
    return Html::a($icon, $params);
}

function create_link_delete($item) {
    setSession();
    $icon = '<span class="glyphicon glyphicon-pencil"></span>';
    $params = ['/word/deleteIndex', 'id' => $item->id_word, 'page' => $page, 'per_page' => $per_page];
    return Html::a($icon, $params);
}
?>
<div class="text-word-index">

    <h1><?//= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить слова', ['create', 'id_text' => $id_text], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Угадай', ['guess', 'id_text' => $id_text], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Написать', ['write', 'id_text' => $id_text], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Учить', ['teach', 'id_text' => $id_text], ['class' => 'btn btn-primary']) ?>
    </p>

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
                'filter' => [1 => 'выучено', 0 => 'не выучено'],
            ],

            ['class' => 'yii\grid\ActionColumn', 'contentOptions' => ['style' => 'width:100px; text-align:center;'],

                'headerOptions' => ['class' => 'text-info'], 'header' => 'Операции', 'template' => '{view} {update} {delete}', 
                'buttons' => [
                    'update' => function ($url, $model) { return create_link_update($model);}

                   // 'delete' => function ($url, $model) { return create_link_delete($model);}
                ],

            ],  


            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
