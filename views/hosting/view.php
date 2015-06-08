<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->domain . ' [# '.$model->id.']';
$this->params['breadcrumbs'][] = ['label' => 'Хостинг', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->domain;

$hosting_alert = Yii::$app->getSession()->getFlash('hosting_alert');
?>
<div class="hosting-view">
	<h1><?= Html::encode($this->title) ?></h1>
	<?= (!empty($hosting_alert)) ? '<p class="bg-success">'.$hosting_alert.'</p>' : '' ?>
	<p>
		<?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?= Html::a('Отправить уведомление', ['update', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
		<?= Html::a('Продлить на 5 дней', ['extension', 'id' => $model->id, 'day' => 5], ['class' => 'btn btn-warning']) ?>
		<?= Html::a('Продлить на год', ['extension', 'id' => $model->id, 'day' => 365], ['class' => 'btn btn-success']) ?>
	</p>
	<?php
	$dataClients = $model->getUsers()->all();
	$clients = '';
	$count = count($dataClients);
	$index = 1;
	foreach ($dataClients as $client) {
		$clients .= '<a href="'.Yii::$app->urlManager->createUrl(['/clients/view', 'id' => $client->id]).'">'.$client->name.'</a>';
		if ($index != $count) {
			$clients .= '<br />';
		}
		$index++;
	}

	echo DetailView::widget([
		'model' => $model,
		'attributes' => [
			[
				'attribute' => 'hosting_state',
				'value' => $model->getHostingStatusesValue(),
			],
			[
				'attribute' => 'paid_till',
				'value' => date('d.m.Y H:i', $model->paid_till),
			],
			[
				'attribute' => 'hosting_face',
				'value' => $model->getHostingFacesValue(),
			],
			[
				'label' => 'Владельцы',
				'format' => 'html',
				'value' => $clients,
			],
			[
				'attribute' => 'hosting_notification_user',
				'value' => $model->getHostingNoticeUserValue(),
			],
			[
				'attribute' => 'hosting_notification_admin',
				'value' => $model->getHostingNoticeAdminValue(),
			],
			[
				'attribute' => 'rate',
				'value' => $model->getPrice()->one()->value.' руб.',
			],
			'extended_info',
		],
	]);
	?>
</div>