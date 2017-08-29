<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>



<?php

echo Yii::t('pages/default', 'MODULE_NAME');
$form = ActiveForm::begin([
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => '{label}<div class="col-sm-10">{input}{error}</div>',
                'labelOptions' => ['class' => 'col-sm-2 control-label'],
            ],
        ]);
?>

<?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
<?= $form->field($model, 'seo_alias')->textInput(['maxlength' => 255]) ?>
<?= $form->field($model, 'text')->textArea(['rows' => 6]) ?>

<div class="form-group text-center">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'CREATE') : Yii::t('app', 'UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>


