<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\data\ActiveDataProvider;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Управляющие', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$dataUsersLog = new ActiveDataProvider([
	'query' => $model->getUsersLogs()->limit(100)->orderBy('date DESC'),
	'sort' => false,
	'pagination' => false,
]);
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
	<?php 
	echo GridView::widget([
		'id' => 'userslog-by-client',
		'dataProvider' => $dataUsersLog,
		'summary' => '',
		'columns' => [
			[
				'attribute' => 'date',
				'contentOptions' => ['width' => 150],
				'format' => 'html',
				'value' => function ($dataUsersLog) {
					return date('d.m.Y H:i', $dataUsersLog->date);
				},
			],
			[
				'attribute' => 'message',
				'format' => 'html',
				'value' => function ($dataUsersLog) {
					return $dataUsersLog->message;
				},
			],
		],
	]);
	?>
</div>
