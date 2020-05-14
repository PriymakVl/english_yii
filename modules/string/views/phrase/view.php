<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Sound;

/* @var $this yii\web\View */
/* @var $model app\models\Phrase */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Текст', 'url' => ['text/view', 'id' => $model->id_text]];
$this->params['breadcrumbs'][] = ['label' => 'Предложения', 'url' => ['/sentense/text', 'id_text' => $model->id_text]];
$this->params['breadcrumbs'][] = ['label' => 'Фразы', 'url' => ['text', 'id_text' => $model->id_text]];
$this->params['breadcrumbs'][] = ['label' => 'Слова', 'url' => ['/text-word', 'id_text' => $model->id_text]];

\yii\web\YiiAsset::register($this);

function create_sound_player($model) {
    if (!$model->sound_id) return '<span class="red">нет</span>';
    $sound = Sound::findOne(['id' => $model->sound_id, 'status' => STATUS_ACTIVE]);
    if (!$sound) return '<span class="red">нет</span>';
    return sprintf('<audio controls src="/sounds/%s"></audio>', $sound->filename);
}
?>
<div class="phrase-view">

    <h1>Фраза</h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'engl',
            'ru',
            'id_sentense',
            ['attribute' => 'saund', 'format' => 'raw', 'value' => function($model) {return create_sound_player($model);}
            ],
        ],
    ]) ?>

</div>
