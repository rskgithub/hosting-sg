<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Управляющие';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">
	<h1><?= Html::encode($this->title) ?></h1>
	<?php
	echo GridView::widget([
		'id' => 'users-list',
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
					return '<a href="'.Yii::$app->urlManager->createUrl(['/users/view', 'id' => $dataProvider->id]).'">'.$dataProvider->name.'</a>';
				}
			],
			'email',
			[
				'attribute' => 'status',
				'format' => 'html',
				'value' => function ($dataProvider) {
					return $dataProvider->getUserStatusesValue();
				}
			],
		],
	]);
	?>
</div>
