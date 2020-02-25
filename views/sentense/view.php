<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Sound;

$words = $model->getWords();

$this->title = 'Предложение №'.$model->currentNum. ' всего предложений: '.$model->allQty;

$this->params['breadcrumbs'][] = ['label' => 'Текст', 'url' => ['/text/view', 'id' => $model->id_text]];
$this->params['breadcrumbs'][] = ['label' => 'Предложения', 'url' => ['index', 'id_text' => $model->id_text]];
$this->params['breadcrumbs'][] = ['label' => 'Слова', 'url' => ['/text-word', 'id_text' => $model->id_text]];

\yii\web\YiiAsset::register($this);

function create_ru($ru)
{
    return sprintf('<a href="#" str="%s" onclick="show_ru(this);">Показать перевод</a>', $ru); 
}

function create_variants_ru($model)
{
    $variants_str = '<a href="#" onclick="show_variants(this);">Показать варианты</a><div id="variants_ru">';
    $number = 1;
    foreach ($model->variantsRu as $id => $text) {
        $str = sprintf('<a href="#" id_variant="%s" id_sentense="%s" onclick="check_variant(this);">%s</a><br><br>', $id, $model->id, $text); 
        $variants_str .= '<span class="variant_ru">' . $number . ') ' . $str . '</span>';
        $number++;
    }
    return $variants_str.'</div>'; 
}

function create_words($words) {
    if (!$words) return false;
    $list_words = '<a href="#" onclick="show_words(this);">Показать слова</a><ul id="words" style="display:none;">';
    foreach ($words as $word) {
        $list_words .= sprintf('<li><span>%s</span>&nbsp;&nbsp;=&nbsp;&nbsp;<span>%s<span></li>', $word->engl, $word->ru);
    }
    return $list_words.'</ul>';
}

function create_link_voice($model) {
    // return '<i class="fas fa-volume-up"></i>';
    if (!$model->sound_id) return 'нет';
    $sound = Sound::findOne(['id' => $model->sound_id, 'status' => STATUS_ACTIVE]);
    if (!$sound) return 'нет';
    return sprintf('<audio controls src="/sounds/%s"></audio>', $sound->filename);
}

?>

<style> 
#variants_ru {
    display: none;
}
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
        <?= Html::a('Previous', ['view', 'id' => $model->id, 'id_text' => $model->id_text, 'direction' => 'previous'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Next', ['view', 'id' => $model->id, 'id_text' => $model->id_text, 'direction' => 'next'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'engl',
            ['attribute' => 'ru', 'label' => 'Перевод', 'format' => 'raw',
                'value' => function($model) {return create_ru($model->ru);}, 
            ],
            ['attribute' => 'variantsRu', 'label' => 'Варианты ответов', 'format' => 'raw',
                'value' => function($model) {return create_variants_ru($model);}, 
            ],

            ['attribute' => 'words', 'label' => 'Слова', 'format' => 'raw',
                'value' => function($model) {return create_words($model->getWords());}, 
            ],

            ['attribute' => 'saund', 'format' => 'raw', 'value' => function($model) {return create_link_voice($model);}
            ],
        ],
    ]) ?>

</div>

<!-- js scripts  -->
<script type="text/javascript">

function show_ru(link) {
    let str = link.getAttribute('str');
    let parent = link.parentNode;
    parent.innerText = str;
    link.style.display = 'none';
    return false;
}

function show_variants(link) {
    document.getElementById('variants_ru').style.display = 'block';
    link.style.display = 'none';
}

function check_variant(link) {
    let id_variant = link.getAttribute('id_variant');
    let id_sentense = link.getAttribute('id_sentense');
    if (id_sentense == id_variant) alert('Верно');
    else alert('Ошибка');
}

function show_words(link) {
    document.getElementById('words').style.display = 'block';
    link.style.display = 'none';
}
</script>
