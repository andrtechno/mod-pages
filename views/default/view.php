<?php
use panix\engine\widgets\Pjax;
Pjax::begin([
    'timeout' => 5000,
    'id'=>'pages-view'
]);
?>
<h1><?= $model->isString('name'); ?></h1>



<p><?= $model->renderText(); ?></p>



<?php Pjax::end(); ?>


<?php
echo panix\mod\comments\widgets\comment\CommentWidget::widget(['model'=>$model]);
?>