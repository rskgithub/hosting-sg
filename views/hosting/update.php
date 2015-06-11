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
		echo $form->field($model, 'hosting_state')->dropDownList($model->getHostingStatusesArray());
		if ($model->paid_till > time() && $model->hosting_state == 1) {
			echo $form->field($model, 'hosting_freeze')->dropDownList($model->getHostingFreezesArray());
		}
		echo $form->field($model, 'paid_till')->widget(\yii\jui\DatePicker::classname(), ['language' => 'ru', 'dateFormat' => 'dd.MM.yyyy', 'options' => ['class' => 'form-control']])->hint('Не рекомендуется изменять дату в ручном режиме.');
		echo $form->field($model, 'hosting_face')->dropDownList($model->getHostingFacesArray());
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
