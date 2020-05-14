<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Sound;

/* @var $this yii\web\View */
/* @var $model app\models\Word */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Words', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

function create_link_state($item) {
    // $page = Yii::$app->request->get('page');
    // $params = ['text-word/state-index', 'id' => $item->id, 'page' => $page ? $page : 1];
    // $params['state'] = $item->state == TextWord::STATE_NOT_LEARNED ? 1 : 0;
    // $style['class'] = $item->state == TextWord::STATE_NOT_LEARNED ? 'text-danger' : 'text-success';
    // $name = $item->state == TextWord::STATE_NOT_LEARNED ? 'не выучено' : 'выучено';
    // return Html::a($name, $params, $style);
    return 'состояние';
}

function create_link_voice($model) {
    // return '<i class="fas fa-volume-up"></i>';
    if (!$model->sound_id) return 'нет';
    $sound = Sound::findOne(['id' => $model->sound_id, 'status' => STATUS_ACTIVE]);
    if (!$sound) return 'нет';
    return sprintf('<audio controls loop src="/sounds/%s"></audio>', $sound->filename);
}
?>
<div class="word-view">

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
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'engl',
            'ru',
            ['attribute' => 'state', 'label' => 'Состояние', 'format' => 'raw',
                'value' => function($model) {return create_link_state($model);}, 
            ],

            ['attribute' => 'saund', 'format' => 'raw', 'value' => function($model) {return create_link_voice($model);}
            ],
        ],
    ]) ?>

</div>
