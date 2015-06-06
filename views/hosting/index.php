<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Хостинг';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hosting-index">

	<h1><?= Html::encode($this->title) ?></h1>

	<?= GridView::widget([
		'id' => 'hosting-list',
		'dataProvider' => $dataProvider,
		'summary' => '',
		'rowOptions' => function($dataProvider) {
			$class = '';
			if ($dataProvider->hosting_state == 0) {
				$class = 'disable';
			} else {
				switch ($dataProvider->hosting_notification_user)
				{
					case '1': $class = 'warning-2w'; break;
					case '2': $class = 'warning-2d'; break;
					// TODO: Этого статуса ещё нет. Он будет появляться, когда будут продлять на 5 дней в ручную
					case '3': $class = 'warning-credit'; break;
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
				'value' => function ($dataProvider) {
					return '<a href="'.Yii::$app->urlManager->createUrl(['/hosting/view', 'id' => $dataProvider->id]).'">'.$dataProvider->domain.'</a>';
				}
			],
			[
				'attribute' => 'hosting_state',
				'contentOptions' => ['width' => 100],
				'value' => function ($dataProvider) {
					return $dataProvider->getHostingStatusesValue();
				}
			],
			[
				'attribute' => 'paid_till',
				'contentOptions' => ['width' => 140],
				'value' => function ($dataProvider) {
					return date('d.m.Y H:i', $dataProvider->paid_till);
				}
			],
			[
				'label' => 'Владельцы',
				'format' => 'html',
				'value' => function ($dataProvider) {
					$dataUsers = $dataProvider->getUsers()->all();
					$content = '';
					$count = count($dataUsers);
					$index = 1;
					foreach ($dataUsers as $user) {
						$content .= '<a href="'.Yii::$app->urlManager->createUrl(['/clients/view', 'id' => $user->id]).'">'.$user->name.'</a>';
						if ($index != $count) {
							$content .= '<br />';
						}
						$index++;
					}
					return $content;
				}
			],
			[
				'attribute' => 'hosting_face',
				'contentOptions' => ['width' => 150],
				'value' => function ($dataProvider) {
					return $dataProvider->getHostingFacesValue();
				}
			],
			[
				'attribute' => 'rate',
				'contentOptions' => ['width' => 110],
				'value' => function ($dataProvider) {
					return $dataProvider->getPrice()->one()->value.' руб.';
				}
			],
		],
	]); ?>

</div>
