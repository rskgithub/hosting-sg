<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Авторизация';
$this->params['breadcrumbs'][] = ['label' => 'Управляющие', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$auth_alert = Yii::$app->getSession()->getFlash('auth_message');
?>
<div class="users-login">
	<h1><?= Html::encode($this->title) ?></h1>
	<?php
	echo (!empty($auth_alert)) ? '<p class="bg-success">'.$auth_alert.'</p>' : '';
	$form = ActiveForm::begin(['id' => 'login-form']);
	echo $form->field($model, 'email')->textInput()->label('E-mail');
	echo $form->field($model, 'password')->passwordInput()->label('Пароль');
	echo $form->field($model, 'rememberMe', ['template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>"])->checkbox()->label('Запомнить меня?');
	echo '
	<div class="form-group">
		'.Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']).'
	</div>	
	';
	ActiveForm::end();
	?>
	<div class="form-group">
		<a href="<?= Yii::$app->urlManager->createUrl(['/users/recovery']) ?>">Забыли пароль?</a>
	</div>
</div>
