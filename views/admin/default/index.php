<?php

use yii\helpers\Html;
use panix\engine\grid\GridView;
use panix\engine\widgets\Pjax;

$sum = 1111;
?>


<?php Pjax::begin([]); ?>
<?=

GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'layoutOptions' => ['title' => $this->context->pageName],
    'showFooter' => true,
     //   'footerRowOptions' => ['class' => 'text-center'],
    'rowOptions' => function ($model, $key, $index, $grid) {
        return ['class' => 'sortable-column'];
    },
    'columns' => [
        [
            'class' => 'panix\engine\grid\columns\CheckboxColumn',
            //'footer' => $sum
        ],
        [
            'class' => \panix\engine\grid\sortable\Column::className(),
            'url' => ['/admin/pages/default/sortable']
        ],
        'id',
        'name',
        // 'date_create:datetime',
        [
            'attribute' => 'date_create',
            'format' => 'raw',
            'filter' => \yii\jui\DatePicker::widget([
                'model' => $searchModel,
                'attribute' => 'date_create',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control']
            ]),
            'contentOptions' => ['class' => 'text-center'],
            'value' => function($model) {
        return Yii::$app->formatter->asDatetime($model->date_create, 'php:d D Y H:i:s');
        //return \panix\engine\CMS::date($model->date_create);
    }
        ],
        ['class' => 'panix\engine\grid\columns\ActionColumn'],
    ],
]);
?>
<?php Pjax::end(); ?>

