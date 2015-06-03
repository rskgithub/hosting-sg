<?php

namespace app\models;

use Yii;

class Users extends \yii\db\ActiveRecord
{
	public static function tableName()
	{
		return 'users';
	}

	public function rules()
	{
		return [
			[['email', 'password', 'name', 'passport', 'passport_issued', 'phone', 'address', 'activation_key'], 'required'],
			[['passport', 'passport_issued', 'phone', 'address'], 'string'],
			[['status'], 'integer'],
			[['email'], 'string', 'max' => 100],
			[['auth_key'], 'string', 'max' => 32],
			[['password', 'name', 'u_inn', 'u_kpp'], 'string', 'max' => 255],
			[['activation_key'], 'string', 'max' => 60]
		];
	}

	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'email' => 'Email',
			'auth_key' => 'Auth Key',
			'password' => 'Password',
			'name' => 'Name',
			'passport' => 'Passport',
			'passport_issued' => 'Passport Issued',
			'phone' => 'Phone',
			'address' => 'Address',
			'u_inn' => 'U Inn',
			'u_kpp' => 'U Kpp',
			'activation_key' => 'Activation Key',
			'status' => 'Status',
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
