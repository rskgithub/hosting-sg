<?php

use yii\helpers\Html;

$this->title = 'Create Hosting';
$this->params['breadcrumbs'][] = ['label' => 'Hostings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hosting-create">

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>
