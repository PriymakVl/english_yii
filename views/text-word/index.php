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
                'value' => function($model) {return Word::findOne($model->id_word)->engl;}, 
            ],

            ['attribute' => 'engl', 'label' => 'Русские', 'format' => 'raw',
                'value' => function($model) {return Word::findOne($model->id_word)->ru;}, 
            ],

            ['class' => 'yii\grid\ActionColumn', 'contentOptions' => ['style' => 'width:100px; text-align:center;'],

                'headerOptions' => ['class' => 'text-info'], 'header' => 'Операции', 'template' => '{view} {update} {delete}', 
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['/word/update', 'id' => $model->id_word]);
                    }
                ],

            ],  


            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
