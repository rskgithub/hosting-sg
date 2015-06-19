<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
 
$this->title = 'Восстановление пароля';
$this->params['breadcrumbs'][] = ['label' => 'Управляющие', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$auth_alert = Yii::$app->getSession()->getFlash('auth_message');
?>
<div class="user-default-recovery">
	<h1><?= Html::encode($this->title) ?></h1>
	<?= (!empty($auth_alert)) ? '<p class="bg-success">'.$auth_alert.'</p>' : '' ?>
	<div class="row">
		<div class="col-lg-5">
			<?php
			$form = ActiveForm::begin(['id' => 'recovery-form']);
			echo $form->field($model, 'email')->label('E-mail');
			echo '
			<div class="form-group">
				'.Html::submitButton('Сбросить пароль', ['class' => 'btn btn-primary', 'name' => 'recovery-button']).'
			</div>			
			';
			ActiveForm::end();
			?>
		</div>
	</div>
</div>
