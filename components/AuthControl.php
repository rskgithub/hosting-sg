<?php
namespace app\components;

use Yii;
use yii\base\ActionFilter;

class AuthControl extends ActionFilter
{
	public function beforeAction($action)
	{
		if (strlen(Yii::$app->user->identity->auth_key) == 0) {
			if ($action->uniqueId == 'users/login' || $action->uniqueId == 'users/recovery') {
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
