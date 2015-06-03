<?php

use yii\helpers\Html;

$this->title = 'Update Pay Log: ' . ' ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Pay Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pay-log-update">

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>
