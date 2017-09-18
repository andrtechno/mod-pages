<?php

use yii\helpers\Html;
use panix\engine\grid\GridView;
use panix\engine\widgets\Pjax;

$sum = 1111;
?>


<?php
Pjax::begin([
    'timeout' => 5000,
    'id'=>  'pjax-'.strtolower(basename($dataProvider->query->modelClass)),


]);
//echo Html::beginForm(['/admin/pages/default/test'],'post',['id'=>'test','name'=>'test']);
echo GridView::widget([
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
        ['class' => 'panix\engine\grid\columns\CheckboxColumn',],
        [
            'class' => \panix\engine\grid\sortable\Column::className(),
            'url' => ['/admin/pages/default/sortable']
        ],
        'id',
        'name',
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
    }
        ],
        ['class' => 'panix\engine\grid\columns\ActionColumn'],
    ],
]);

 Pjax::end(); ?>

