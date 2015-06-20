<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Users;

class LoginForm extends Model
{
	public $email;
	public $password;
	public $rememberMe = true;

	private $_user = false;

	public function rules()
	{
		return [
			['email', 'filter', 'filter' => 'trim'],
			['email', 'required', 'message' => 'Вы не указали свой E-mail.'],
			['email', 'email', 'message' => 'Вы указали не корректный E-mail.'],
			['password', 'required', 'message' => 'Вы не указали пароль.'],
			['password', 'validatePassword'],
			['rememberMe', 'boolean'],
		];
	}
	
	public function validatePassword()
	{
		if (!$this->hasErrors()) {
			$user = $this->getUser();
 
			if (!$user || !$user->validatePassword($this->password)) {
				$this->addError('password', 'Неверное имя пользователя или пароль.');
			}
		}
	}

	public function login()
	{
		if ($this->validate()) {
			$model = $this->getUser();
			$model->generateAuthKey();
			if (Yii::$app->user->login($model, $this->rememberMe ? 3600 * 24 * 30 : 0)) {
				$role = Users::getRoleArray();
				$auth = Yii::$app->authManager;
				$auth->revokeAll(Yii::$app->user->identity->id);
				$auth->assign($auth->getRole($role[Yii::$app->user->identity->status]), Yii::$app->user->identity->id);
				if ($model->save()) {
					return true;
				} else {
					return false;
				}
			}
		} else {
			return false;
		}
	}
	
	public function getUser()
	{
		if ($this->_user === false) {
			$this->_user = Users::findByEmail($this->email);
		}

		return $this->_user;
	}
}
