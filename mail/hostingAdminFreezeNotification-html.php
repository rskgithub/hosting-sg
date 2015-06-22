<?php
use yii\helpers\Html;

$this->title = '[SalesGeneration Хостинг] Активация заморозки для хостинга';

$owners = [];
foreach ($arOwners as $owner) {
	$owners[] = $owner->name.' ('.$user->email.')';
}
?>
<p>Активирована услуга заморозки на 5 дней для хостинга:</p>

<ul>
	<li><?= Html::encode($hosting->domain) ?> (ID: <?= Html::encode($hosting->id) ?>; Оплачен до: <?= Html::encode(date('d.m.Y', $hosting->paid_till)) ?>) - <?= implode(', ', $owners) ?></li>
</ul>
