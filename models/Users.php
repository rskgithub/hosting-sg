<?php

namespace app\models;

use Yii;

class Users extends \yii\db\ActiveRecord
{
	const USER_STATUS_CLIENT = 0;
	const USER_STATUS_MANAGER = 1;
	const USER_STATUS_ADMIN = 2;
	
	public static function getUserStatusesArray()
	{
		return [
			self::USER_STATUS_CLIENT => 'Клиент',
			self::USER_STATUS_MANAGER => 'Оператор',
			self::USER_STATUS_ADMIN => 'Администратор',
		];
	}
	
	public function getUserStatusesValue()
	{
		$statuses = self::getUserStatusesArray();
		return isset($statuses[$this->status]) ? $statuses[$this->status] : '';
	}
	
	public static function tableName()
	{
		return 'users';
	}
	
	public function scenarios()
	{
		$scenarios = parent::scenarios();
		$scenarios['create'] = ['name', 'email', 'status'];
		$scenarios['update'] = ['name', 'email', 'phone', 'address', 'passport', 'passport_issued', 'u_inn', 'u_kpp', 'status'];
		return $scenarios;
	}

	public function rules()
	{
		return [
			[['name', 'email'], 'required'],
			[['name', 'phone', 'address', 'passport', 'passport_issued', 'u_inn', 'u_kpp'], 'string', 'max' => 255],
			['email', 'email'],
			['email', 'unique', 'targetClass' => self::className(), 'message' => 'Этот e-mail уже используется'],
			['email', 'string', 'max' => 100],
			['status', 'integer'],
			['status', 'default', 'value' => 0],
		];
	}

	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'email' => 'E-mail',
			'name' => 'Клиент',
			'passport' => 'Серия и номер паспорта',
			'passport_issued' => 'Кем и когда выдан паспорт',
			'phone' => 'Телефон',
			'address' => 'Адрес',
			'u_inn' => 'ИНН',
			'u_kpp' => 'КПП',
			'status' => 'Роль',
		];
	}

	public function getHostingUsers()
	{
		return $this->hasMany(HostingUsers::className(), ['user_id' => 'id']);
	}

	public function getHosting()
	{
		return $this->hasMany(Hosting::className(), ['id' => 'information_id'])->viaTable('information_users', ['user_id' => 'id']);
	}

	public function getPayLogs()
	{
		return $this->hasMany(PayLog::className(), ['user_ID' => 'id']);
	}
}
