<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TextWordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Слова';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="text-word-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить слова', ['create', 'id_text' => $id_text], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_text',
            'id_word',
            'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
