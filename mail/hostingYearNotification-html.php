<?php
use yii\helpers\Html;

$this->title = 'Успешное продление хостинга на год';
?>
<p>Уважаемый(ая), <?= Html::encode($user->name) ?>!</p>

<p>Хостинг для домена <?= Html::encode($hosting->domain) ?> успешно продлён до <?= Html::encode(date('d.m.Y', $hosting->paid_till)) ?></p>
