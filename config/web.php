<?php

$config = [
	'id' => 'basic',
	'name' => 'Hosting Control Panel',
	'language' => 'ru-RU',
	'basePath' => dirname(__DIR__),
	'bootstrap' => ['log'],
	'defaultRoute' => 'hosting',
	'components' => [
		'authManager' => [
			'class' => 'yii\rbac\PhpManager',
			'defaultRoles' => ['manager', 'admin'],
			'itemFile' => '@app/components/rbac/items.php',
			'assignmentFile' => '@app/components/rbac/assignments.php',
			'ruleFile' => '@app/components/rbac/rules.php'
		],
		'request' => [
			'cookieValidationKey' => 'TjNadAD3okPlGle85Mn6457IBW2NvT2r',
		],
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'user' => [
			'identityClass' => 'app\models\Users',
			'enableAutoLogin' => true,
			'loginUrl' => ['/users/login'],
		],
		'mailer' => [
			'class' => 'yii\swiftmailer\Mailer',
			'useFileTransport' => false,
		],
		'log' => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['info'],
					'categories' => ['hosting'],
					'logVars' => [],
					'logFile' => '@app/web/notification.log',
				],
			],
		],
		'db' => require(__DIR__ . '/db.php'),
	],
	'params' => require(__DIR__ . '/params.php'),
];

if (YII_ENV_DEV) {
	$config['bootstrap'][] = 'debug';
	$config['modules']['debug'] = 'yii\debug\Module';

	$config['bootstrap'][] = 'gii';
	$config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
