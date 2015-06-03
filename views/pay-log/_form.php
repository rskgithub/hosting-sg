<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="pay-log-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'date')->textInput() ?>

	<?= $form->field($model, 'user_ID')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'hosting_name')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'value')->textInput() ?>

	<?= $form->field($model, 'state')->textInput() ?>

	<div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
