<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SentenseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Предложения';

$this->params['breadcrumbs'][] = ['label' => 'Текст', 'url' => ['/text/view', 'id' => $text->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sentense-index">

    <h1><?= Html::encode($text->title) ?></h1>

    <table  class="table table-bordered table-striped">
        <tr>
            <th>№</th>
            <th>Английский</th>
            <th>Русский</th>
            <th></th>
        </tr>
        <? $number = 1; ?>
        <? foreach ($sentenses as $sentense): ?>
            <tr>
                <td>
                    <?= Html::a($number, ['sentense/view', 'id_text' => $text->id, 'id' => $sentense->id]) ?>
                </td>
                <td><?=$sentense->engl?></td>
                <td><?=$sentense->ru?></td>
                <td></td>
            </tr>
            <? $number++; ?>
        <? endforeach; ?>
    </table>



</div>
