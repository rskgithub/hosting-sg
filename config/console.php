<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

return [
	'id' => 'basic-console',
	'basePath' => dirname(__DIR__),
	'bootstrap' => ['log', 'gii'],
	'controllerNamespace' => 'app\commands',
	'modules' => [
		'gii' => 'yii\gii\Module',
	],
	'components' => [
		'authManager' => [
			'class' => 'yii\rbac\PhpManager',
			'defaultRoles' => ['manager', 'admin'],
			'itemFile' => '@app/components/rbac/items.php',
			'assignmentFile' => '@app/components/rbac/assignments.php',
			'ruleFile' => '@app/components/rbac/rules.php'
		],
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'log' => [
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
		'db' => $db,
	],
	'params' => $params,
];
