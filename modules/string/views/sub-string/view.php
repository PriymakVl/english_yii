<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Sound;
use app\helpers\BreadcrumbsHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Phrase */

$this->title = 'Фраза';

$bc_cat = BreadcrumbsHelper::category($model->text->category);
$bc_text = BreadcrumbsHelper::text($model->text->id);
$this->params['breadcrumbs'] = array_merge($bc_cat, ['...'], $bc_text);


\yii\web\YiiAsset::register($this);

function create_sound_player($model) {
    if (!$model->sound) return '<span class="red">нет</span>';
    return sprintf('<audio controls src="/sounds/%s"></audio>', $model->sound->filename);
}

function create_link_string($model)
{
    $text = $model->getString('engl');
    $title = $model->getString('ru');
    $url = '/string/view?id='.$model->str_id;
    return Html::a($text, [$url], ['title' => $title]);
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
            ['attribute' => 'str_id', 'format' => 'raw', 'value' => function($model) {return create_link_string($model);} ],
            [
                'attribute' => 'sound', 'format' => 'raw', 'value' => function($model) {return create_sound_player($model);}
            ],
        ],
    ]) ?>

</div>
