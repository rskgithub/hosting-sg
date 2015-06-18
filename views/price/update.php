<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Редактирование цены: #'.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Цены', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="price-update">
	<h1><?= Html::encode($this->title) ?></h1>
	<div class="price-form">
		<?php
		$form = ActiveForm::begin();
		echo $form->field($model, 'value')->textInput();
		echo $form->field($model, 'comment')->textInput(['maxlength' => true]);
		echo '
		<div class="form-group">
			'.Html::submitButton('Сохранить', ['class' => 'btn btn-primary']).'
		</div>
		';
		ActiveForm::end();
		?>
	</div>
</div>
