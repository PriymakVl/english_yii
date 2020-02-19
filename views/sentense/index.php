<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Sound;

$this->title = 'Предложения';
$this->params['breadcrumbs'][] = ['label' => 'Тексты', 'url' => ['/text']];
$this->params['breadcrumbs'][] = $this->title;

function create_link_voice($model) {
    // return '<i class="fas fa-volume-up"></i>';
    if (!$model->sound_id) return 'нет';
    $sound = Sound::findOne(['id' => $model->sound_id, 'status' => STATUS_ACTIVE]);
    if (!$sound) return 'нет';
    return sprintf('<audio controls src="sounds/%s"></audio>', $sound->filename);
}

?>
<div class="sentense-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать файл для озвучки', ['/sound/create-file', 'type' => Sound::TYPE_SENTENSE], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Добавить озвучку', ['/sound/add-sounds', 'type' => Sound::TYPE_SENTENSE], ['class' => 'btn btn-primary']) ?>
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
