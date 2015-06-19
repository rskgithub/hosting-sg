<?php
use yii\helpers\Html;

$this->title = 'Восстановление пароля';

if ($user->status > 0) {
	$resetURL = Yii::$app->urlManager->createAbsoluteUrl(['/users/recovery', 'key' => $user->activation_key]);
	$resetLink = Html::a(Html::encode($resetURL), $resetURL);
} else {
	$resetLink = '<a href="http://my.salesgeneration.ru/recovery/?user='.$user->id.'&key='.$user->activation_key.'">http://my.salesgeneration.ru/recovery/?user='.$user->id.'&key='.$user->activation_key.'</a>';
}
?>
<p>Здравствуйте, <?= Html::encode($user->name) ?>!</p>

<p>Для восстановления пароля перейдите по ссылке:</p>

<p><?= $resetLink ?></p><br />

<p>Письмо создано автоматической системой оповещения.</p>
