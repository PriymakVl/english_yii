<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\BreadcrumbsHelper;

$this->title = 'Абзацы текста';

$bc_cat = BreadcrumbsHelper::category($text->category);
$bc_text = BreadcrumbsHelper::text($text->id);
$this->params['breadcrumbs'] = array_merge($bc_cat, $bc_text);

?>

<div class="sub-texts-text">

    <h1><?= "Абзацы текста:" . $text->title  ?></h1>

    <p>
        <?= Html::a('Добавить абзац', ['/sub-text/create', 'text_id' => $text->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php if ($subtexts): ?>
        <table class="table table-striped table-bordered">
            <tr>
                <th width="100">#</th>
                <th>Engl</th>
                <th>Ru</th>
                <th width="150">Actions</th>
            </tr>
            <? $num = 1; ?>
            <?php foreach ($subtexts as $sub): ?>
                <tr>
                    <td><?= $num ?></td>
                    <td>
                        <?= $sub->engl ?>
                    </td>
                    <td>
                    	<?= $sub->ru ?>
                    </td>
                    <td>
                    	<a href="<?= Url::to(['view', 'id' => $sub->id]) ?>">
                    		<i class="far fa-eye"></i>
                    	</a><br>
						<a href="<?= Url::to(['update', 'id' => $sub->id]) ?>">
                    		<i class="far fa-edit"></i>
                    	</a><br>
                    	<a href="<?= Url::to(['delete', 'id' => $sub->id]) ?>">
                    		<i class="fas fa-trash-alt"></i>
                    	</a>
                    </td>
                </tr>
                <? $num++; ?>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
    	<p color="red">Абзацев еще нет</p>
    <?php endif ?>

</div>
