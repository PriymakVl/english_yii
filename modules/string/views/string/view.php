<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Sound;
use yii\widgets\ActiveForm;

$words = $model->getWords();

$this->title = 'Предложение №'.$model->currentNum. ' всего предложений: '.$model->allQty;

$this->params['breadcrumbs'][] = ['label' => 'Текст', 'url' => ['/text/view', 'id' => $model->id_text]];
$this->params['breadcrumbs'][] = ['label' => 'Предложения', 'url' => ['text', 'id_text' => $model->id_text]];
$this->params['breadcrumbs'][] = ['label' => 'Фразы', 'url' => ['/phrase/text', 'id_text' => $model->id_text]];
$this->params['breadcrumbs'][] = ['label' => 'Слова', 'url' => ['/text-word', 'id_text' => $model->id_text]];

\yii\web\YiiAsset::register($this);

function create_words($words) {
    if (!$words) return '<span class="red">нет</span>';
    $list_words = '<span id="toggle-words" onclick="show_words();">Список слов</span><ul id="list-words" class="hidden">';
    foreach ($words as $word) {
        $list_words .= sprintf('<li><span>%s</span>&nbsp;&nbsp;=&nbsp;&nbsp;<span>%s<span></li>', $word->engl, $word->ru);
    }
    return $list_words.'</ul>';
}

function create_phrases($phrases) {
    if (!$phrases) return '<span class="red">нет</span>';
    $list_phrases = '<ul>';
    foreach ($phrases as $phrase) {
        $list_phrases .= sprintf('<li>%s</li>', $phrase->engl);
    }
    return $list_phrases.'</ul>';
}

function create_sound_player($model) {
    if (!$model->sound_id) return '<span class="red">нет</span>';
    $sound = Sound::findOne(['id' => $model->sound_id, 'status' => STATUS_ACTIVE]);
    if (!$sound) return '<span class="red">нет</span>';
    return sprintf('<audio controls src="/sounds/%s"></audio>', $sound->filename);
}

?>

<style>
    #toggle-words {
        text-decoration: underline;
        font-size: 1.2em;
    }
    #toggle-words {
        cursor: pointer;
    }
    .hidden {
        display: none;
    }
    .
</style>

<div class="sentense-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Previous', ['view', 'id' => $model->id, 'direction' => 'prev'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Next', ['view', 'id' => $model->id, 'direction' => 'next'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Shift up engl', ['shift', 'id' => $model->id, 'lang' => 'engl'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Shift up ru', ['shift', 'id' => $model->id, 'lang' => 'ru'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'engl',
            'ru',

            ['attribute' => 'phrases', 'label' => 'Фразы', 'format' => 'raw',
                'value' => function($model) {return create_phrases($model->phrases);}, 
            ],
 
            ['attribute' => 'words', 'label' => 'Слова', 'format' => 'raw',
                'value' => function($model) {return create_words($model->getWords());}, 
            ],

            ['attribute' => 'saund', 'format' => 'raw', 'value' => function($model) {return create_sound_player($model);}
            ],
        ],
    ]) ?>

    <h2>Форма для добавления фраз</h2>

    <?php $form = ActiveForm::begin(['action' => '/phrase/create']); ?>

        <?= $form->field($phrase, 'engl')->textarea(['rows' => '1']) ?>

        <?= $form->field($phrase, 'ru')->textarea(['rows' => '1']) ?>

        <?= $form->field($phrase, 'id_text')->hiddenInput(['value' => $model->id_text])->label(false) ?>

        <?= $form->field($phrase, 'id_sentense')->hiddenInput(['value' => $model->id])->label(false) ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>


</div>

<!-- js scripts  -->
<script>
    function show_words() {
        words = document.getElementById('list-words');
        words.classList.toggle('hidden');
    }
</script>
