<?php

namespace app\models;

use Yii;

class Hosting extends \yii\db\ActiveRecord
{
	const HOSTING_STATUS_OFF = 0;
	const HOSTING_STATUS_ON = 1;
	const HOSTING_FACE_UR = 0;
	const HOSTING_FACE_FIZ = 1;
	
	public static function getHostingStatusesArray()
	{
		return [
			self::HOSTING_STATUS_OFF => 'Выключен',
			self::HOSTING_STATUS_ON => 'Включён',
		];
	}
	
	public function getHostingStatusesValue()
	{
		$statuses = self::getHostingStatusesArray();
		return isset($statuses[$this->hosting_state]) ? $statuses[$this->hosting_state] : '';
	}
	
	public static function getHostingFacesArray()
	{
		return [
			self::HOSTING_FACE_UR => 'Юридическое лицо',
			self::HOSTING_FACE_FIZ => 'Физическое лицо',
		];
	}
	
	public function getHostingFacesValue()
	{
		$statuses = self::getHostingFacesArray();
		return isset($statuses[$this->hosting_face]) ? $statuses[$this->hosting_face] : '';
	}
	
	public static function tableName()
	{
		return 'information';
	}
	
	public function rules()
	{
		return [
			[['domain', 'aliases', 'state', 'pdd_token', 'charsetsourceenc', 'charsetdefault', 'charsetpriority', 'php_default_charset', 'php_open_basedir', 'php_mbstring_func_overload', 'http_base_auth', 'http_base_auth_user', 'http_base_auth_password', 'hosting', 'hosting_user', 'hosting_password', 'contract_number', 'client_name', 'client_passport', 'client_passport_issued', 'client_registration_address', 'client_phone', 'client_actual_address', 'client_extended_info', 'domain_created', 'domain_paid_till', 'sg_account_created', 'sg_account_paid_till', 'admin_path', 'admin_user', 'admin_password', 'admin_email', 'admin_email_password', 'ssh_user', 'ssh_host', 'ssh_password', 'ssh_key', 'ssh_site_path', 'ftp_user', 'ftp_host', 'ftp_password', 'mysql_database', 'mysql_user', 'mysql_host', 'mysql_password', 'mysql_database_encoding', 'mysql_database_charset', 'mysql_database_collate', 'extended_info'], 'string'],
			[['aliases', 'hidden', 'pdd_token', 'charsetsourceenc', 'charsetdefault', 'charsetpriority', 'php_default_charset', 'php_open_basedir', 'http_base_auth', 'http_base_auth_user', 'http_base_auth_password', 'hosting_password', 'client_name', 'client_passport', 'client_passport_issued', 'client_registration_address', 'client_phone', 'client_actual_address', 'client_extended_info', 'admin_email', 'admin_email_password', 'mysql_database_encoding', 'mysql_database_charset', 'mysql_database_collate'], 'required'],
			[['hidden', 'paid_till', 'hosting_state', 'hosting_face', 'hosting_notification_user', 'hosting_notification_admin', 'rate'], 'integer']
		];
	}
	
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'domain' => 'Хостинг',
			'paid_till' => 'Оплачен до',
			'hosting_state' => 'Состояние',
			'hosting_face' => 'Лицо',
			'hosting_notification_user' => 'Hosting Notification User',
			'hosting_notification_admin' => 'Hosting Notification Admin',
			'rate' => 'Стоимость',
		];
	}
	
	public function getPrice()
	{
		return $this->hasOne(Price::className(), ['id' => 'rate']);
	}

	public function getHostingUsers()
	{
		return $this->hasMany(HostingUsers::className(), ['information_id' => 'id']);
	}

	public function getUsers()
	{
		return $this->hasMany(Users::className(), ['id' => 'user_id'])->viaTable('information_users', ['information_id' => 'id']);
	}
}
