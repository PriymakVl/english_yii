<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Sentense */

$this->title = 'Предложение №'.$model->currentNum. ' всего предложений: '.$model->allQty;
$this->params['breadcrumbs'][] = ['label' => 'Sentenses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

create_variants_ru($model->variantsRu);

function create_ru($ru)
{
    return sprintf('<a href="#" str="%s" onclick="show_ru(this);">Показать перевод</a>', $ru); 
}

function create_variants_ru($variants_ru)
{
    $variants_str = '<a href="#" onclick="show_variants(this);">Показать варианты</a><br>';
    $number = 1;
    foreach ($variants_ru as $id => $text) {
        $str = sprintf('<a href="#" id_str="%s" onclick="check_variant(this);">%s</a><br>', $id, $text); 
        $variants_str .= '<span class="variant_ru">' . $number . ') ' . $str . '</span>';
        $number++;
    }
    return $variants_str; 
}

?>

<style> 
.variant_ru {
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
                'value' => function($model) {return create_variants_ru($model->variantsRu);}, 
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
</script>
