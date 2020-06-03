<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Sound;

$this->title = 'Предложения';
$this->params['breadcrumbs'][] = ['label' => 'Тексты', 'url' => ['/text']];
$this->params['breadcrumbs'][] = $this->title;

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
            ['attribute' => 'saund', 'format' => 'raw', 'value' => function($model) {return $model->getSoundPlayer();}],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
