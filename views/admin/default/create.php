<?php

use yii\helpers\Html;
//use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $model app\modules\pages\models\Pages */

$this->title = Yii::t('app', 'Create Pages');

?>
 <?//= Alert::widget() ?>


<div class="pages-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
