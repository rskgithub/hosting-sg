<?php
use yii\helpers\Html;

$this->title = 'Уведомление о приближающемся сроке оплаты хостинга';
?>
<p>Уважаемый(ая), <?= Html::encode($user->name) ?>!</p><br />

<p>На Ваше имя зарегистрирован хостинг для домена <?= Html::encode($hosting->domain) ?></p>

<p>Холдинг SalesGeneration является официальным партнером FastVPS и оказывает владельцам доменных имен услуги по предоставлению хостинга.</p><br />

<p>Сообщаем Вам, что срок действия Вашего хостинга истекает <?= Html::encode(date('d.m.Y', $hosting->paid_till)) ?>.</p>

<p>Для предотвращения прерываний в работе Вашего ресурса, Вам необходимо внести оплату в размере <?= Html::encode(number_format($hosting->getPrice()->one()->value, 0, '', ' ')) ?> рублей за годовое обслуживание.</p>

<p>Для осуществления оплаты пройдите по ссылке: <a href="http://my.salesgeneration.ru">http://my.salesgeneration.ru</a></p>
