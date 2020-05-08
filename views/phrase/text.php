<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Sound;
use yii\widgets\LinkPager;


/* @var $this yii\web\View */
/* @var $searchModel app\models\SentenseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Фразы';

$this->params['breadcrumbs'][] = ['label' => 'Текст', 'url' => ['/text/view', 'id' => $text->id]];
$this->params['breadcrumbs'][] = ['label' => 'Предложения', 'url' => ['/sentense/text', 'id_text' => $text->id]];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = ['label' => 'Слова', 'url' => ['/text-word', 'id_text' => $text->id]];

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
         <?= Html::a('Создать файл для озвучки', ['/sound/create-file', 'type' => Sound::TYPE_PHRASE, 'text_id' => $text->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Добавить озвучку', ['/sound/add-sounds', 'type' => Sound::TYPE_PHRASE], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Добавить фразы', ['add-from-files', 'id_text' => $text->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Озвучить', ['sounds', 'id_text' => $text->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Повторять', ['repeat', 'id_text' => $text->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <? if ($phrases): ?>
        <table  class="table table-bordered table-striped">
            <tr>
                <th>№</th>
                <th>Английский</th>
                <th>Озвучка</th>
                <th>Русский</th>
            </tr>
            <? $number = 1; ?>
            <? foreach ($phrases as $phrase): ?>
                <tr>
                    <td>
                        <?= Html::a($number, ['phrase/view', 'id' => $phrase->id]) ?>
                    </td>
                    <td><?=$phrase->engl?></td>
                    <td>
                        <?= create_sound_player($phrase); ?>
                    </td>
                    <td><?=$phrase->ru?></td>
                </tr>
                <? $number++; ?>
            <? endforeach; ?>
        </table>

       <?php echo LinkPager::widget(['pagination' => $pages,]); ?>

    <? else: ?>
        <div class="alert alert-warning" role="alert">
            У этого текста фраз еще нет
        </div>
    <? endif; ?>

</div>
