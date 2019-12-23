<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Word;

$this->title = 'Слова';
$this->params['breadcrumbs'][] = ['label' => 'Текст', 'url' => ['/text/view', 'id' => $id_text]];
$this->params['breadcrumbs'][] = ['label' => 'Предложения', 'url' => ['/sentense', 'id_text' => $id_text]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="text-word-index">

    <h1><?//= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить слова', ['create', 'id_text' => $id_text], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Угадай', ['guess', 'id_text' => $id_text], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute' => 'engl', 'label' => 'Английские', 'format' => 'raw',
                'value' => function($model) {return Word::findOne($model->id)->engl;}, 
            ],

            ['attribute' => 'engl', 'label' => 'Русские', 'format' => 'raw',
                'value' => function($model) {return Word::findOne($model->id)->ru;}, 
            ],


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
