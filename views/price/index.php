<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Цены';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="price-index">
	<h1><?= Html::encode($this->title) ?></h1>
	<p><?= Html::a('Добавить цену', ['create'], ['class' => 'btn btn-success']) ?></p>
	<?php
	echo GridView::widget([
		'id' => 'prices-list',
		'dataProvider' => $dataProvider,
		'summary' => '',
		'columns' => [
			[
				'attribute' => 'id',
				'contentOptions' => ['width' => 70],
			],
			[
				'attribute' => 'value',
				'contentOptions' => ['width' => 200],
				'format' => 'html',
				'value' => function ($dataProvider) {
					return $dataProvider->value.' руб.';
				}
			],
			[
				'label' => 'Количество хостингов',
				'contentOptions' => ['width' => 200],
				'format' => 'html',
				'value' => function ($dataProvider) {
					return $dataProvider->getHostings()->count();
				}
			],
			'comment',
			[
				'class' => 'yii\grid\ActionColumn',
				'contentOptions' => ['width' => 50],
				'buttons' => [
					'view' => function($url, $model) {
						return '';
					},
					'update',
					'delete'
				],
			],
		],
	]);
	?>
</div>
