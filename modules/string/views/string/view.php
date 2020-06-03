<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Sound;
use yii\widgets\ActiveForm;
use app\helpers\BreadcrumbsHelper;

$this->title = 'Предложение';

$bc_cat = BreadcrumbsHelper::category($model->text->category);
$bc_text = BreadcrumbsHelper::text($model->text->id);
$this->params['breadcrumbs'] = array_merge($bc_cat, ['...'], $bc_text);

\yii\web\YiiAsset::register($this);

function create_words($model) {
    if (!$model->words) return '<span class="red">нет</span>';
    $words = '<span id="toggle-words" onclick="show_words(this);">Показать слова</span><ul id="list-words" class="hidden">';
    foreach ($model->words as $word) {
        $words .= sprintf('<li title="%s"><a href="/word/view?id=%s">%s</a></li>', $word->ru, $word->id, $word->engl);
    }
    return $words.'</ul>';
}

function create_substrings($model) {
    if (!$model->substrings) return '<span class="red">нет</span>';
    $substrings = '<span id="toggle-substr" onclick="show_substr(this);">Показать фразы</span>';
    $substrings .= '<ul id="list-substr" class="hidden">';
    foreach ($model->substrings as $substr) {
        $substrings .= sprintf('<li title="%s"> <a href="/substring/view?id=%s">%s</a> </li>', $substr->ru, $substr->id, $substr->engl);
    }
    return $substrings.'</ul>';
}

?>

<style>
    #toggle-words, #toggle-substr {
        text-decoration: underline;
        font-size: 1.2em;
        cursor: pointer;
    }

    #list-words li, #list-substr li {
        cursor: default;
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
        <?= Html::a('Previous', ['view', 'id' => $model->getPrevItemId()], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Next', ['view', 'id' => $model->getNextItemId()], ['class' => 'btn btn-primary']) ?>
        <?//= Html::a('Shift up engl', ['shift', 'id' => $model->id, 'lang' => 'engl'], ['class' => 'btn btn-primary']) ?>
        <?//= Html::a('Shift up ru', ['shift', 'id' => $model->id, 'lang' => 'ru'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'engl',
            'ru',

            ['attribute' => 'substrings', 'label' => 'Фразы', 'format' => 'raw',
                'value' => function($model) {return create_substrings($model);}, 
            ],
 
            ['attribute' => 'words', 'label' => 'Слова', 'format' => 'raw',
                'value' => function($model) {return create_words($model);}, 
            ],

            ['attribute' => 'saund', 'format' => 'raw', 'value' => function($model) {return $model->getSoundPlayer();}
            ],
        ],
    ]) ?>

    <h2>Форма для добавления фраз</h2>

    <?php $form = ActiveForm::begin(['action' => '/substring/add-from-string']); ?>

        <?= $form->field($substr, 'engl')->textarea(['rows' => '1']) ?>

        <?= $form->field($substr, 'ru')->textarea(['rows' => '1']) ?>

        <?= $form->field($substr, 'text_id')->hiddenInput(['value' => $model->text_id])->label(false) ?>

        <?= $form->field($substr, 'subtext_id')->hiddenInput(['value' => $model->subtext_id])->label(false) ?>

        <?= $form->field($substr, 'str_id')->hiddenInput(['value' => $model->id])->label(false) ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>


</div>

<!-- js scripts  -->
<script>
    function show_words(toggleBtn) {
        toggleBtn.innerText = toggleBtn.innerText == 'Показать слова' ? 'Скрыть слова' : 'Показать слова';
        words = document.getElementById('list-words');
        words.classList.toggle('hidden');
    }

    function show_substr(toggleBtn) {
        toggleBtn.innerText = toggleBtn.innerText == 'Показать фразы' ? 'Скрыть фразы' : 'Показать фразы';
        words = document.getElementById('list-substr');
        words.classList.toggle('hidden');
    }
</script>
