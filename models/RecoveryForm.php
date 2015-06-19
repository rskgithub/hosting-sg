<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Users;

class RecoveryForm extends Model
{
	public $email;
	
	public function rules()
	{
		return [
			['email', 'filter', 'filter' => 'trim'],
			['email', 'required', 'message' => 'Вы не указали E-mail.'],
			['email', 'email', 'message' => 'Вы указали не корректный E-mail.'],
			['email', 'exist', 'targetClass' => Users::className(), 'message' => 'Пользователя с таким E-mail не обнаружено.'],
		];
	}
	
	public function sendEmail()
	{
		$user = Users::findByEmail($this->email);
		
		if ($user) {
			$user->generateActivationKey();
			
			if ($user->save()) {
				return Yii::$app->mailer->compose(['html' => 'passwordRecoveryKey-html'], ['user' => $user])
					->setFrom([Yii::$app->params['supportEmail'] => 'SalesGeneration'])
					->setTo($this->email)
					->setSubject('Восстановление пароля от системы управления хостингом')
					->send();
			}
		}
		
		return false;
	}
}
