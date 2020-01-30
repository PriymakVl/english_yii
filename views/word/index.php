<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Слова';
$this->params['breadcrumbs'][] = ['label' => 'Тексты', 'url' => ['/text']];
$this->params['breadcrumbs'][] = $this->title;

function create_link_voice($model) {
    // return '<i class="fas fa-volume-up"></i>';
    if ($model->sound_id) return '<a href="#">озвучить</a>';
    return 'нет';
}

?>
<div class="word-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить слово', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Озвучка', ['/sound/create-file'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'engl',
            'ru',
             ['attribute' => 'saund', 'format' => 'raw', 'value' => function($model) {return create_link_voice($model);}],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
