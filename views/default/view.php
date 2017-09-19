<?php
use panix\engine\widgets\Pjax;
Pjax::begin([
    'timeout' => 5000,

]);
?>
<h1><?= $model->isString('name'); ?></h1>
<p><?= $model->renderText(); ?></p>
<?php Pjax::end(); ?>