<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Добавить клиента';
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clients-create">
	<h1><?= Html::encode($this->title) ?></h1>
	<div class="clients">
	<?php
	$form = ActiveForm::begin();
	echo $form->field($model, 'name')->textInput(['maxlength' => true]);
	echo $form->field($model, 'email')->textInput(['maxlength' => true]);
	echo '
	<div class="form-group">
		'.Html::submitButton('Добавить', ['class' => 'btn btn-primary']).'
	</div>		
	';
	ActiveForm::end();
	?>
	</div>
</div>
