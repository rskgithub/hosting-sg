<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a('Create Users', ['create'], ['class' => 'btn btn-success']) ?>
	</p>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			'id',
			'email:email',
			'auth_key',
			'password',
			'name',
			// 'passport:ntext',
			// 'passport_issued:ntext',
			// 'phone:ntext',
			// 'address:ntext',
			// 'u_inn',
			// 'u_kpp',
			// 'activation_key',
			// 'status',

			['class' => 'yii\grid\ActionColumn'],
		],
	]); ?>

</div>
