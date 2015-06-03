<?php

namespace app\models;

use Yii;

class Hosting extends \yii\db\ActiveRecord
{
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
			'domain' => 'Domain',
			'aliases' => 'Aliases',
			'hidden' => 'Hidden',
			'state' => 'State',
			'pdd_token' => 'Pdd Token',
			'charsetsourceenc' => 'Charsetsourceenc',
			'charsetdefault' => 'Charsetdefault',
			'charsetpriority' => 'Charsetpriority',
			'php_default_charset' => 'Php Default Charset',
			'php_open_basedir' => 'Php Open Basedir',
			'php_mbstring_func_overload' => 'Php Mbstring Func Overload',
			'http_base_auth' => 'Http Base Auth',
			'http_base_auth_user' => 'Http Base Auth User',
			'http_base_auth_password' => 'Http Base Auth Password',
			'hosting' => 'Hosting',
			'hosting_user' => 'Hosting User',
			'hosting_password' => 'Hosting Password',
			'contract_number' => 'Contract Number',
			'client_name' => 'Client Name',
			'client_passport' => 'Client Passport',
			'client_passport_issued' => 'Client Passport Issued',
			'client_registration_address' => 'Client Registration Address',
			'client_phone' => 'Client Phone',
			'client_actual_address' => 'Client Actual Address',
			'client_extended_info' => 'Client Extended Info',
			'domain_created' => 'Domain Created',
			'domain_paid_till' => 'Domain Paid Till',
			'sg_account_created' => 'Sg Account Created',
			'sg_account_paid_till' => 'Sg Account Paid Till',
			'admin_path' => 'Admin Path',
			'admin_user' => 'Admin User',
			'admin_password' => 'Admin Password',
			'admin_email' => 'Admin Email',
			'admin_email_password' => 'Admin Email Password',
			'ssh_user' => 'Ssh User',
			'ssh_host' => 'Ssh Host',
			'ssh_password' => 'Ssh Password',
			'ssh_key' => 'Ssh Key',
			'ssh_site_path' => 'Ssh Site Path',
			'ftp_user' => 'Ftp User',
			'ftp_host' => 'Ftp Host',
			'ftp_password' => 'Ftp Password',
			'mysql_database' => 'Mysql Database',
			'mysql_user' => 'Mysql User',
			'mysql_host' => 'Mysql Host',
			'mysql_password' => 'Mysql Password',
			'mysql_database_encoding' => 'Mysql Database Encoding',
			'mysql_database_charset' => 'Mysql Database Charset',
			'mysql_database_collate' => 'Mysql Database Collate',
			'extended_info' => 'Extended Info',
			'paid_till' => 'Paid Till',
			'hosting_state' => 'Hosting State',
			'hosting_face' => 'Hosting Face',
			'hosting_notification_user' => 'Hosting Notification User',
			'hosting_notification_admin' => 'Hosting Notification Admin',
			'rate' => 'Rate',
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
