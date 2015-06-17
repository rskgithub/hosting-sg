<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Hosting;

$this->title = 'Добавление хостинга';
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $client->name, 'url' => ['view', 'id' => $client->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hosting-users-create">
	<h1><?= Html::encode($this->title) ?></h1>
	<div class="hosting-users-form">
	<?php
	$form = ActiveForm::begin([
		'action' => Yii::$app->urlManager->createUrl(['/clients/hosting', 'action' => 'save', 'client_id' => $client->id]),
	]);
	echo $form->field($model, 'information_id')->dropDownList(ArrayHelper::map(Hosting::find()->orderBy('domain ')->all(), 'id', 'domain'));
	echo $form->field($model, 'user_id')->hiddenInput(['maxlength' => true, 'value' => $client->id])->label(false)->error(false);
	echo '
	<div class="form-group">
		'.Html::submitButton('Добавить', ['class' => 'btn btn-primary']).'
	</div>		
	';
	ActiveForm::end();
	?>
	</div>
</div>
