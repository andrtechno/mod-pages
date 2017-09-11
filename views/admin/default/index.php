<?php

use yii\helpers\Html;
use panix\engine\grid\sortable\SortableGridView;
use yii\widgets\Pjax;
?>

<div class="pages-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>


    <?php Pjax::begin(); ?>
    <?=
    SortableGridView::widget([
        'tableOptions' => ['class' => 'table table-striped'],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layoutOptions' => ['title' => $this->context->pageName],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'date_create:datetime',
        [
            'attribute' => 'date_create',
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
            'value' => function($model) {
                return \panix\engine\CMS::date($model->date_create);
            }
        ],
            ['class' => 'panix\engine\grid\columns\ActionColumn'],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>
