<?php
return [
	'userDelete' => [
		'type' => 2,
	],
	'userRoleChange' => [
		'type' => 2,
	],
	'hostingDelete' => [
		'type' => 2,
	],
	'hostingAdd' => [
		'type' => 2,
	],
	'hostingExtensionYear' => [
		'type' => 2,
	],
	'hostingRateEdit' => [
		'type' => 2,
	],
	'rateCreate' => [
		'type' => 2,
	],
	'rateEdit' => [
		'type' => 2,
	],
	'rateDelete' => [
		'type' => 2,
	],
	'manager' => [
		'type' => 1,
		'ruleName' => 'userRole',
	],
	'admin' => [
		'type' => 1,
		'ruleName' => 'userRole',
		'children' => [
			'manager',
			'userDelete',
			'userRoleChange',
			'hostingDelete',
			'hostingAdd',
			'hostingExtensionYear',
			'hostingRateEdit',
			'rateCreate',
			'rateEdit',
			'rateDelete',
		],
	],
];
