<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use app\components\rbac\UserRoleRule;

class RbacController extends Controller
{
	public function actionInit()
	{
		$auth = Yii::$app->authManager;
		$auth->removeAll();
		
		// Правила
		$userRule = new UserRoleRule();
		$auth->add($userRule);
		
		// Права (admin only)
		// Удаление пользователя
		$userDelete = $auth->createPermission('userDelete');
		$auth->add($userDelete);
		// Изменение роли пользователя
		$userRoleChange = $auth->createPermission('userRoleChange');
		$auth->add($userRoleChange);
		// Удаление хостинга у пользователя
		$hostingDelete = $auth->createPermission('hostingDelete');
		$auth->add($hostingDelete);
		// Добавление хостинга пользователю
		$hostingAdd = $auth->createPermission('hostingAdd');
		$auth->add($hostingAdd);
		// Продление хостинга на год
		$hostingExtensionYear = $auth->createPermission('hostingExtensionYear');
		$auth->add($hostingExtensionYear);
		// Изменение стоимости хостинга
		$hostingRateEdit = $auth->createPermission('hostingRateEdit');
		$auth->add($hostingRateEdit);
		// Добавлени цены
		$rateCreate = $auth->createPermission('rateCreate');
		$auth->add($rateCreate);
		// Изменение цены
		$rateEdit = $auth->createPermission('rateEdit');
		$auth->add($rateEdit);
		// Удаление цены
		$rateDelete = $auth->createPermission('rateDelete');
		$auth->add($rateDelete);
		
		// Роли
		$manager = $auth->createRole('manager');
		$manager->ruleName = $userRule->name;
		$auth->add($manager);
		
		$admin = $auth->createRole('admin');
		$admin->ruleName = $userRule->name;
		$auth->add($admin);
		$auth->addChild($admin, $manager);
		$auth->addChild($admin, $userDelete);
		$auth->addChild($admin, $userRoleChange);
		$auth->addChild($admin, $hostingDelete);
		$auth->addChild($admin, $hostingAdd);
		$auth->addChild($admin, $hostingExtensionYear);
		$auth->addChild($admin, $hostingRateEdit);
		$auth->addChild($admin, $rateCreate);
		$auth->addChild($admin, $rateEdit);
		$auth->addChild($admin, $rateDelete);
	}
}
