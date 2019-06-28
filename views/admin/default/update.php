<?php
use yii\helpers\Html;
use panix\engine\bootstrap\ActiveForm;
use panix\ext\tinymce\TinyMce;

$form = ActiveForm::begin();
?>
<div class="card">
    <div class="card-header">
        <h5><?= Html::encode($this->context->pageName) ?></h5>
    </div>
    <div class="card-body">
        <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'slug')->textInput(['maxlength' => 255]) ?>
        <?=
        $form->field($model, 'text')->widget(TinyMce::class, [
            'options' => ['rows' => 6],
        ]);
        ?>
    </div>
    <div class="card-footer text-center">
        <?= $model->submitButton(); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
