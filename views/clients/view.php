<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\data\ActiveDataProvider;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$dataHostings = new ActiveDataProvider([
	'query' => $model->getHosting()->orderBy('paid_till'),
	'sort' => false,
	'pagination' => false,
]);

$dataPays = new ActiveDataProvider([
	'query' => $model->getPayLogs()->orderBy(['date' => SORT_DESC]),
	'sort' => false,
	'pagination' => false,
]);

$clients_alert = Yii::$app->getSession()->getFlash('clients_alert');
$clients_alert_status = Yii::$app->getSession()->getFlash('clients_alert_status');
if (empty($clients_alert_status))
	$clients_alert_status = 'success';
?>
<div class="clients-view">
	<h1><?= Html::encode($this->title) ?></h1>
	<?= (!empty($clients_alert)) ? '<p class="bg-'.$clients_alert_status.'">'.$clients_alert.'</p>' : '' ?>
	<p><?php
	echo Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
	if (Yii::$app->user->can('userDelete')) {
		echo ' '.Html::a('Удалить', ['delete', 'id' => $model->id], [
			'class' => 'btn btn-danger',
			'data' => [
				'confirm' => 'Вы уверены, что хотите удалить этого клиента?',
				'method' => 'post',
			],
		]);
	}
	if ($model->status > 0) {
		echo ' '.Html::a('Профиль управляющего', ['/users/view', 'id' => $model->id], ['class' => 'btn btn-info']);
	}
	?></p>
	<?php
	echo DetailView::widget([
		'model' => $model,
		'attributes' => [
			'email:ntext',
			'phone:ntext',
			'address:ntext',
			'passport:ntext',
			'passport_issued:ntext',
			'u_inn',
			'u_kpp',
			[
				'attribute' => 'status',
				'value' => $model->getUserStatusesValue(),
			],
		],
	]);
	?>
	<br />
	<h2>Хостинг</h2>
	<?php
	if (Yii::$app->user->can('hostingAdd')) {
		echo '<p>'.Html::a('Добавить хостинг', ['hosting', 'action' => 'add', 'client_id' => $model->id], ['class' => 'btn btn-success']).'</p>';
	}
	echo GridView::widget([
		'id' => 'hostings-by-client',
		'dataProvider' => $dataHostings,
		'summary' => '',
		'rowOptions' => function($dataHostings) {
			$class = '';
			if ($dataHostings->hosting_state == 0) {
				$class = 'disable';
			} else {
				switch ($dataHostings->notification_user)
				{
					case '1': $class = 'warning-2w'; break;
					case '2': $class = 'warning-2d'; break;
					case '3': $class = 'warning-freeze'; break;
					case '4': $class = 'disable'; break;
				}
			}
			return ['class' => $class];
		},
		'columns' => [
			[
				'attribute' => 'id',
				'contentOptions' => ['width' => 70],
			],
			[
				'attribute' => 'domain',
				'contentOptions' => ['width' => 210],
				'format' => 'html',
				'value' => function ($dataHostings) {
					return '<a href="'.Yii::$app->urlManager->createUrl(['/hosting/view', 'id' => $dataHostings->id]).'">'.$dataHostings->domain.'</a>';
				}
			],
			[
				'attribute' => 'hosting_state',
				'contentOptions' => ['width' => 100],
				'value' => function ($dataHostings) {
					return $dataHostings->getHostingStatusesValue();
				}
			],
			[
				'attribute' => 'paid_till',
				'contentOptions' => ['width' => 140],
				'value' => function ($dataHostings) {
					if ($dataHostings->paid_till > 0) {
						return date('d.m.Y H:i', $dataHostings->paid_till);
					}
				}
			],
			[
				'attribute' => 'hosting_freeze',
				'contentOptions' => ['width' => 75],
				'value' => function ($dataHostings) {
					return $dataHostings->getHostingFreezesValue();
				}
			],
			[
				'attribute' => 'hosting_face',
				'contentOptions' => ['width' => 150],
				'value' => function ($dataHostings) {
					return $dataHostings->getHostingFacesValue();
				}
			],
			[
				'attribute' => 'rate',
				'contentOptions' => ['width' => 110],
				'value' => function ($dataHostings, $model) {
					if ($dataHostings->rate > 0) {
						return $dataHostings->getPrice()->one()->value.' руб.';
					}
				}
			],
			[
				'label' => 'Управление',
				'contentOptions' => ['width' => 100],
				'format' => 'html',
				'value' => function ($dataHostings) use ($model) {
					return (Yii::$app->user->can('hostingDelete')) ? Html::a('Удалить', ['hosting', 'action' => 'delete', 'client_id' => $model->id, 'hosting_id' => $dataHostings->id], ['class' => 'btn btn-danger']) : '';
				}
			],
		],
	]);
	?>
	<br />
	<h2>История платежей</h2>
	<?php 
	echo GridView::widget([
		'id' => 'pays-by-client',
		'dataProvider' => $dataPays,
		'summary' => '',
		'columns' => [
			[
				'attribute' => 'ID',
				'contentOptions' => ['width' => 100],
				'format' => 'html',
				'value' => function ($dataPays) {
					return $dataPays->date.'-'.$dataPays->ID;
				}
			],
			[
				'attribute' => 'date',
				'contentOptions' => ['width' => 150],
				'format' => 'html',
				'value' => function ($dataPays) {
					return date('d.m.Y H:i', $dataPays->date);
				}
			],
			'hosting_name',
			[
				'attribute' => 'value',
				'contentOptions' => ['width' => 100],
				'format' => 'html',
				'value' => function ($dataPays) {
					return $dataPays->value.' руб.';
				}
			],
			[
				'attribute' => 'state',
				'contentOptions' => ['width' => 150],
				'value' => function ($dataPays) {
					return $dataPays->getPayStatusesValue();
				}
			],
		],
	]);
	?>
</div>
