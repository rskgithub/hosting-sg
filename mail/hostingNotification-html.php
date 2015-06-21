<?php
use yii\helpers\Html;

$this->title = 'Уведомление о приближающемся сроке оплаты хостинга';

if ($hosting->paid_till <= (time() - 3600 * 24 * 5) && $hosting->hosting_freeze == 1) {
	$hosting_status_info = '<p>Сообщаем Вам, что срок действия Вашего хостинга <strong>истёк</strong> '.Html::encode(date('d.m.Y', $hosting->paid_till + 3600 * 24 * 5)).'.</p>';
} elseif ($hosting->paid_till <= time() && $hosting->hosting_freeze == 1) {
	$hosting_status_info = '<p>Сообщаем Вам, что срок действия Вашего хостинга <strong>продлён</strong> и истекает '.Html::encode(date('d.m.Y', $hosting->paid_till + 3600 * 24 * 5)).'.</p>';
} else {
	$hosting_status_info = '<p>Сообщаем Вам, что срок действия Вашего хостинга <strong>истекает</strong> '.Html::encode(date('d.m.Y', $hosting->paid_till)).'.</p>';
}
?>
<p>Уважаемый(ая), <?= Html::encode($user->name) ?>!</p><br />

<p>На Ваше имя зарегистрирован хостинг для домена <?= Html::encode($hosting->domain) ?></p>

<p>Холдинг SalesGeneration является официальным партнером FastVPS и оказывает владельцам доменных имен услуги по предоставлению хостинга.</p><br />

<?= $hosting_status_info ?>

<p>Для предотвращения прерываний в работе Вашего ресурса, Вам необходимо внести оплату в размере <?= Html::encode(number_format($hosting->getPrice()->one()->value, 0, '', ' ')) ?> рублей за годовое обслуживание.</p>

<p>Для осуществления оплаты пройдите по ссылке: <a href="http://my.salesgeneration.ru">http://my.salesgeneration.ru</a></p>
