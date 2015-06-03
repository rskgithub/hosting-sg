<?php

use yii\helpers\Html;

$this->title = 'Create Pay Log';
$this->params['breadcrumbs'][] = ['label' => 'Pay Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pay-log-create">

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>
