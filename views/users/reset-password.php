<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
 
$this->title = 'Смена пароля';
$this->params['breadcrumbs'][] = ['label' => 'Управляющие', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-reset-password">
	<h1><?= Html::encode($this->title) ?></h1>
	<div class="row">
		<div class="col-lg-5">
			<?php
			$form = ActiveForm::begin(['id' => 'reset-password-form']);
			echo $form->field($model, 'password')->passwordInput(['autocomplete' => 'off'])->label('Новый пароль');
			echo $form->field($model, 'password_again')->passwordInput(['autocomplete' => 'off'])->label('Повторите пароль');
			echo '
			<div class="form-group">
				'.Html::submitButton('Сохранить пароль', ['class' => 'btn btn-primary', 'name' => 'reset-password-button']).'
			</div>			
			';
			ActiveForm::end();
			?>
		</div>
	</div>
</div>
