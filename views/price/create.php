<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Добавить цену';
$this->params['breadcrumbs'][] = ['label' => 'Цены', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="price-create">
	<h1><?= Html::encode($this->title) ?></h1>
	<div class="price-form">
		<?php
		$form = ActiveForm::begin();
		echo $form->field($model, 'value')->textInput();
		echo $form->field($model, 'comment')->textInput(['maxlength' => true]);
		echo '
		<div class="form-group">
			'.Html::submitButton('Добавить', ['class' => 'btn btn-success']).'
		</div>
		';
		ActiveForm::end();
		?>
	</div>
</div>
