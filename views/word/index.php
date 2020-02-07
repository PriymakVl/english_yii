<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Sound;

$this->title = 'Слова';
$this->params['breadcrumbs'][] = ['label' => 'Тексты', 'url' => ['/text']];
$this->params['breadcrumbs'][] = $this->title;

function create_link_voice($model) {
    // return '<i class="fas fa-volume-up"></i>';
    if (!$model->sound_id) return 'нет';
    $sound = Sound::findOne(['id' => $model->sound_id, 'status' => STATUS_ACTIVE]);
    if (!$sound) return 'нет';
    return '<audio controls src="sounds/<?=$sound->filename?>"></audio>';
}

?>
<div class="word-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <audio controls>
    <source src="/sounds/10.wav">
    </audio>

    <p>
        <?= Html::a('Добавить слово', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Создать файл для озвучки', ['/sound/create-file'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Добавить озвучку', ['/sound/add-sounds'], ['class' => 'btn btn-primary']) ?>
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
