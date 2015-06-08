<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Price;

$this->title = 'Изменение настроек для ' . $model->domain . ' [# '.$model->id.']';
$this->params['breadcrumbs'][] = ['label' => 'Хостинг', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->domain, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменение настроек';
?>
<div class="hosting-update">
	<h1><?= Html::encode($this->title) ?></h1>
	<div class="hosting-form">
		<?php
		$form = ActiveForm::begin();
		echo $form->field($model, 'hosting_state')->dropDownList(['0' => 'Выключен', '1' => 'Включён']);
		echo $form->field($model, 'hosting_face')->dropDownList(['0' => 'Юридическое лицо', '1' => 'Физическое лицо']);
		echo $form->field($model, 'rate')->dropDownList(ArrayHelper::map(Price::find()->all(), 'id', 'value'));
		echo $form->field($model, 'extended_info')->textarea(['rows' => 4]);
		echo '
		<div class="form-group">
			'.Html::submitButton('Сохранить', ['class' => 'btn btn-primary']).'
		</div>		
		';
		ActiveForm::end();
		?>
	</div>
</div>
