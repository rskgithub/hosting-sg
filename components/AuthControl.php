<?php
namespace app\components;

use Yii;
use yii\base\ActionFilter;

class AuthControl extends ActionFilter
{
	public function beforeAction($action)
	{
		if (!isset(Yii::$app->user->identity->auth_key)) {
			if ($action->uniqueId == 'users/login' || $action->uniqueId == 'users/recovery' || $action->uniqueId == 'hosting/control') {
				return parent::beforeAction($action);
			} else {
				Yii::$app->user->logout();
				Yii::$app->response->redirect(['/users/login']);
			}
		} else {
			return parent::beforeAction($action);
		}
	}
}
