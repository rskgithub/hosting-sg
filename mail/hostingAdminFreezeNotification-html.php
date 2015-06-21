<?php
use yii\helpers\Html;

$this->title = '[SalesGeneration Хостинг] Активация заморозки для хостинга';
?>
<p>Активирована услуга заморозки на 5 дней для хостинга:</p>

<ul>
	<li><?= Html::encode($hosting->domain) ?> (ID: <?= Html::encode($hosting->id) ?>; Оплачен до: <?= Html::encode(date('d.m.Y', $hosting->paid_till)) ?>) - <?= Html::encode($user->name) ?> (<?= Html::encode($user->email) ?>)</li>
</ul>
