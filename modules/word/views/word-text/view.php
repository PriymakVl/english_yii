<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Word;

$this->title = 'Слово';
$this->params['breadcrumbs'][] = ['label' => 'Текст', 'url' => ['/text', 'id' => $model->id_text]];
$this->params['breadcrumbs'][] = ['label' => 'Предложения', 'url' => ['/sentense', 'id_text' => $model->id_text]];
$this->params['breadcrumbs'][] = ['label' => 'Слова', 'url' => ['index', 'id_text' => $model->id_text]];

\yii\web\YiiAsset::register($this);


function create_sentenses($sentenses) {
    if (!$sentenses) return;
    $list_sentenses = '<ul>';
    foreach ($sentenses as $sentense) {
        $list_sentenses .= sprintf('<li>%s<br>%s</li>', $sentense['engl'], $sentense['ru']);
        if ($number > 1) break;
        $number++;
    }
    return $list_sentenses.'</ul>';
}

?>

<div class="text-word-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['before-update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить это слово?',
                'method' => 'post',
            ],
        ]) ?>

        <?= Html::a('Previous', ['view', 'id' => $model->id, 'direction' => 'previous'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Next', ['view', 'id' => $model->id, 'direction' => 'next'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['attribute' => 'engl', 'label' => 'Английский',
                'value' => function($model) {return Word::findOne($model->id_word)->engl;}, 
            ],

            ['attribute' => 'ru', 'label' => 'Руский',
                'value' => function($model) {return Word::findOne($model->id_word)->ru;}, 
            ],
            ['attribute' => 'sentenses', 'label' => 'Предложения', 'format' => 'raw',
                'value' => function($model) {return create_sentenses($model->getSentenses());}, 
            ],
        ],
    ]) ?>

</div>
