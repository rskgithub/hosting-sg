<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Pay Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pay-log-index">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a('Create Pay Log', ['create'], ['class' => 'btn btn-success']) ?>
	</p>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			'ID',
			'date',
			'user_ID',
			'hosting_name',
			'value',
			// 'state',

			['class' => 'yii\grid\ActionColumn'],
		],
	]); ?>

</div>
