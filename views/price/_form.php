<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="price-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'value')->textInput() ?>

	<?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

	<div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
