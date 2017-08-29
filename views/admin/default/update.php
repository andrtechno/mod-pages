<?php

use yii\helpers\Html;
?>


<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', ['model' => $model]) ?>
<?php
/*/
echo \pistol88\seo\widgets\SeoForm::widget([
    'model' => $model,
    'form' => $form,
]);*/
?>

