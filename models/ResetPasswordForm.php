<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;
use app\models\Users;

class ResetPasswordForm extends Model
{
	public $password;
	public $password_again;
	
	private $_user;
	
	public function __construct($key, $config = [])
	{
		if (empty($key) || !is_string($key)) {
			throw new InvalidParamException('Ключ восстановления пароля не должен быть пустым.');
		}
		
		$this->_user = Users::findByActivationKey($key);
		if (!$this->_user) {
			throw new InvalidParamException('Ключ восстановления пароля не корректный.');
		}
		parent::__construct($config);
	}
	
	public function rules()
	{
		return [
			[['password', 'password_again'], 'required', 'message' => 'Вы не указали пароль.'],
			[['password', 'password_again'], 'string', 'min' => 6, 'tooShort' => 'Пароль должен быть больше 6 символов.'],
			['password_again', 'compare', 'compareAttribute' => 'password', 'operator' => '==', 'message' => 'Пароли не совпадают.'],
		];
	}
	
	public function resetPassword()
	{
		$user = $this->_user;
		$user->setPassword($this->password);
		$user->removeActivationKey();
		return $user->save(false);
	}
}
?>
