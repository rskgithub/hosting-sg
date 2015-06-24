<?php
use yii\helpers\Html;

$this->title = 'Успешное продление хостинга на год';

if ($hosting->paid_till <= (time() - 3600 * 24 * 5) && $hosting->hosting_freeze == 1) {
	$hosting_status_info = '<p>Сообщаем Вам, что срок действия Вашего хостинга <strong>истёк</strong> '.Html::encode(date('d.m.Y', $hosting->paid_till + 3600 * 24 * 5)).'.</p>';
} elseif ($hosting->paid_till <= time() && $hosting->hosting_freeze == 1) {
	$hosting_status_info = '<p>Сообщаем Вам, что срок действия Вашего хостинга <strong>продлён</strong> и истекает '.Html::encode(date('d.m.Y', $hosting->paid_till + 3600 * 24 * 5)).'.</p>';
} else {
	$hosting_status_info = '<p>Сообщаем Вам, что срок действия Вашего хостинга <strong>истекает</strong> '.Html::encode(date('d.m.Y', $hosting->paid_till)).'.</p>';
}
?>
<p>Уважаемый(ая), <?= Html::encode($user->name) ?>!</p>

<p>Хостинг для домена <?= Html::encode($hosting->domain) ?> успешно продлён до <?= Html::encode(date('d.m.Y', $hosting->paid_till)) ?></p>
