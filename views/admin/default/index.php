<?php

use yii\helpers\Html;
//use app\cms\grid\AdminGridView;
use panix\engine\grid\sortable\SortableGridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pages\models\PagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
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
        'layout' => $this->render('@app/web/themes/admin/views/layouts/_grid_layout', ['title' => $this->context->pageName]), //'{items}{pager}{summary}'
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
