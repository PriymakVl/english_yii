<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Sound;
use app\helpers\BreadcrumbsHelper;

$this->title = 'Предложения';

$this->params['breadcrumbs'] = breadcrumbsHelper::create($text->category, false);
$this->params['breadcrumbs'][] = ['label' => $text->category->name, 'url' => ['/category/texts', 'cat_id' => $text->category->id]];
$this->params['breadcrumbs'][] = ['label' => 'Текст', 'url' => ['/text/view', 'id' => $text->id]];
$this->params['breadcrumbs'][] = ['label' => 'Фразы', 'url' => ['/substring/text', 'text_id' => $text->id]];
$this->params['breadcrumbs'][] = ['label' => 'Слова', 'url' => ['/text-word', 'text_id' => $text->id]];


function create_sound_player($model) {
    if (!$model->sound_id) return '<span class="red">нет</span>';
    $sound = Sound::findOne(['id' => $model->sound_id, 'status' => STATUS_ACTIVE]);
    if (!$sound) return '<span class="red">нет</span>';
    return sprintf('<audio controls src="/sounds/%s"></audio>', $sound->filename);
}
?>
<div class="sentense-index">

    <h1><?= Html::encode($text->title) ?></h1>
    <p>
         <?= Html::a('Создать файл для озвучки', ['/sound/create-file', 'type' => Sound::TYPE_SENTENSE, 'text_id' => $text->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Добавить озвучку', ['/sound/add-sounds', 'type' => Sound::TYPE_SENTENSE], ['class' => 'btn btn-primary']) ?>
    </p>

    <table  class="table table-bordered table-striped">
        <tr>
            <th>№</th>
            <th>Английский</th>
            <th>Озвучка</th>
            <th>Русский</th>
        </tr>
        <? $number = 1; ?>
        <? foreach ($strings as $str): ?>
            <tr>
                <td>
                    <?= Html::a($number, ['sentense/view', 'id' => $str->id]) ?>
                </td>
                <td><?=$str->engl?></td>
                <td>
                    <?= create_sound_player($str); ?>
                </td>
                <td><?=$str->ru?></td>
            </tr>
            <? $number++; ?>
        <? endforeach; ?>
    </table>



</div>
