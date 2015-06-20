<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Изменение клиента ' . $model->name . ' [# '.$model->id.']';
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменение клиента';
?>
<div class="clients-update">
	<h1><?= Html::encode($this->title) ?></h1>
	<div class="clients-form">
		<?php
		$form = ActiveForm::begin();
		echo $form->field($model, 'name')->textInput(['maxlength' => true]);
		echo $form->field($model, 'email')->textInput(['maxlength' => true]);
		echo $form->field($model, 'phone')->textInput(['maxlength' => true]);
		echo $form->field($model, 'address')->textInput(['maxlength' => true]);
		echo $form->field($model, 'passport')->textInput(['maxlength' => true]);
		echo $form->field($model, 'passport_issued')->textInput(['maxlength' => true]);
		echo $form->field($model, 'u_inn')->textInput(['maxlength' => true]);
		echo $form->field($model, 'u_kpp')->textInput(['maxlength' => true]);
		echo (Yii::$app->user->can('userRoleChange')) ? $form->field($model, 'status')->dropDownList($model->getUserStatusesArray()) : '';
		echo '
		<div class="form-group">
			'.Html::submitButton('Сохранить', ['class' => 'btn btn-success']).'
		</div>
		';
		ActiveForm::end();
		?>
	</div>
</div>
