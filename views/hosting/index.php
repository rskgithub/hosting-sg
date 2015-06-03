<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Hostings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hosting-index">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a('Create Hosting', ['create'], ['class' => 'btn btn-success']) ?>
	</p>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			'id',
			'domain:ntext',
			'aliases:ntext',
			'hidden',
			'state:ntext',
			// 'pdd_token:ntext',
			// 'charsetsourceenc:ntext',
			// 'charsetdefault:ntext',
			// 'charsetpriority:ntext',
			// 'php_default_charset:ntext',
			// 'php_open_basedir:ntext',
			// 'php_mbstring_func_overload:ntext',
			// 'http_base_auth:ntext',
			// 'http_base_auth_user:ntext',
			// 'http_base_auth_password:ntext',
			// 'hosting:ntext',
			// 'hosting_user:ntext',
			// 'hosting_password:ntext',
			// 'contract_number:ntext',
			// 'client_name:ntext',
			// 'client_passport:ntext',
			// 'client_passport_issued:ntext',
			// 'client_registration_address:ntext',
			// 'client_phone:ntext',
			// 'client_actual_address:ntext',
			// 'client_extended_info:ntext',
			// 'domain_created:ntext',
			// 'domain_paid_till:ntext',
			// 'sg_account_created:ntext',
			// 'sg_account_paid_till:ntext',
			// 'admin_path:ntext',
			// 'admin_user:ntext',
			// 'admin_password:ntext',
			// 'admin_email:ntext',
			// 'admin_email_password:ntext',
			// 'ssh_user:ntext',
			// 'ssh_host:ntext',
			// 'ssh_password:ntext',
			// 'ssh_key:ntext',
			// 'ssh_site_path:ntext',
			// 'ftp_user:ntext',
			// 'ftp_host:ntext',
			// 'ftp_password:ntext',
			// 'mysql_database:ntext',
			// 'mysql_user:ntext',
			// 'mysql_host:ntext',
			// 'mysql_password:ntext',
			// 'mysql_database_encoding:ntext',
			// 'mysql_database_charset:ntext',
			// 'mysql_database_collate:ntext',
			// 'extended_info:ntext',
			// 'paid_till',
			// 'hosting_state',
			// 'hosting_face',
			// 'hosting_notification_user',
			// 'hosting_notification_admin',
			// 'rate',

			['class' => 'yii\grid\ActionColumn'],
		],
	]); ?>

</div>
