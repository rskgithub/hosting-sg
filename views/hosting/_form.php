<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="hosting-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'domain')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'aliases')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'hidden')->textInput() ?>

	<?= $form->field($model, 'state')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'pdd_token')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'charsetsourceenc')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'charsetdefault')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'charsetpriority')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'php_default_charset')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'php_open_basedir')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'php_mbstring_func_overload')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'http_base_auth')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'http_base_auth_user')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'http_base_auth_password')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'hosting')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'hosting_user')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'hosting_password')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'contract_number')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'client_name')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'client_passport')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'client_passport_issued')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'client_registration_address')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'client_phone')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'client_actual_address')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'client_extended_info')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'domain_created')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'domain_paid_till')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'sg_account_created')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'sg_account_paid_till')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'admin_path')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'admin_user')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'admin_password')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'admin_email')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'admin_email_password')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'ssh_user')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'ssh_host')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'ssh_password')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'ssh_key')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'ssh_site_path')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'ftp_user')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'ftp_host')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'ftp_password')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'mysql_database')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'mysql_user')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'mysql_host')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'mysql_password')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'mysql_database_encoding')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'mysql_database_charset')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'mysql_database_collate')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'extended_info')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'paid_till')->textInput() ?>

	<?= $form->field($model, 'hosting_state')->textInput() ?>

	<?= $form->field($model, 'hosting_face')->textInput() ?>

	<?= $form->field($model, 'hosting_notification_user')->textInput() ?>

	<?= $form->field($model, 'hosting_notification_admin')->textInput() ?>

	<?= $form->field($model, 'rate')->textInput(['maxlength' => true]) ?>

	<div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
