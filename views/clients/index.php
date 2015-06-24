<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Клиенты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clients-index">
	<h1><?= Html::encode($this->title) ?></h1>
	<p><?= Html::a('Добавить клиента', ['create'], ['class' => 'btn btn-success']) ?></p>
	<?php
	echo GridView::widget([
		'id' => 'clients-list',
		'dataProvider' => $dataProvider,
		'summary' => '',
		'columns' => [
			[
				'attribute' => 'id',
				'contentOptions' => ['width' => 70],
			],
			[
				'attribute' => 'name',
				'contentOptions' => ['width' => 525],
				'format' => 'html',
				'value' => function ($dataProvider) {
					return '<a href="'.Yii::$app->urlManager->createUrl(['/clients/view', 'id' => $dataProvider->id]).'">'.$dataProvider->name.'</a>';
				}
			],
			'email',
			[
				'label' => 'Хостинг',
				'format' => 'html',
				'value' => function ($dataProvider) {
					$dataHostings = $dataProvider->getHosting()->all();
					$content = [];
					foreach ($dataHostings as $hosting) {
						$content[] = '<a href="'.Yii::$app->urlManager->createUrl(['/hosting/view', 'id' => $hosting->id]).'">'.$hosting->domain.'</a>';
					}
					return implode('<br />', $content);
				}
			],
		],
	]);
	?>
</div>
