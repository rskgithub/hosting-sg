<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="users-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'passport')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'passport_issued')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'phone')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'u_inn')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'u_kpp')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'activation_key')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'status')->textInput() ?>

	<div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
