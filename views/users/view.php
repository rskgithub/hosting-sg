<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Управляющие', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-view">
	<h1><?= Html::encode($this->title) ?></h1>
	<p><?= Html::a('Профиль клиента', ['/clients/view', 'id' => $model->id], ['class' => 'btn btn-info']) ?></p>
	<?php
	echo DetailView::widget([
		'model' => $model,
		'attributes' => [
			'email:ntext',
			'phone:ntext',
			[
				'attribute' => 'status',
				'value' => $model->getUserStatusesValue(),
			],
		],
	]);
	?>
	<br />
	<h2>Журнал действий</h2>
	<p>Раздел находится в стадии разработки.</p>
</div>
