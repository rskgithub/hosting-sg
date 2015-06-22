<?php
use yii\helpers\Html;

$this->title = '[SalesGeneration Хостинг] Просрочена оплата для хостинга';

$owners = [];
foreach ($arOwners as $owner) {
	$owners[] = $owner->name.' ('.$user->email.')';
}
?>
<p>Услуга хостинга не оплачена для домена:</p>

<ul>
	<li><?= Html::encode($hosting->domain) ?> (ID: <?= Html::encode($hosting->id) ?>; Оплачен до: <?= Html::encode(date('d.m.Y', $hosting->paid_till)) ?>) - <?= implode(', ', $owners) ?></li>
</ul>

<br /><p>Необходимо принять соответствующие меры!</p>
