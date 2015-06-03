<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Prices';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="price-index">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a('Create Price', ['create'], ['class' => 'btn btn-success']) ?>
	</p>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			'id',
			'value',
			'comment',

			['class' => 'yii\grid\ActionColumn'],
		],
	]); ?>

</div>
