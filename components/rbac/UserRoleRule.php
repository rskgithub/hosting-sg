<?php
namespace app\components\rbac;

use Yii;
use yii\rbac\Rule;
use app\models\Users;

class UserRoleRule extends Rule
{
	
	public $name = 'userRole';
	
	public function execute($user, $item, $params)
	{
		if (!Yii::$app->user->isGuest) {
			$role = Yii::$app->user->identity->status;

			if ($item->name === 'admin') {
				return $role == Users::USER_STATUS_ADMIN;
			} elseif ($item->name === 'manager') {
				return $role == Users::USER_STATUS_ADMIN || $role == Users::USER_STATUS_MANAGER;
			}
		}
		return false;
	}

}
?>
