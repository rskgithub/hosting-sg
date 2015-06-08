<?php

namespace app\models;

use Yii;

class Hosting extends \yii\db\ActiveRecord
{
	const HOSTING_STATUS_OFF = 0;
	const HOSTING_STATUS_ON = 1;
	const HOSTING_FACE_UR = 0;
	const HOSTING_FACE_FIZ = 1;
	const HOSTING_NOTICE_USER_NO = 0;
	const HOSTING_NOTICE_USER_2W = 1;
	const HOSTING_NOTICE_USER_2D = 2;
	//const HOSTING_NOTICE_USER_CREDIT = 3;
	const HOSTING_NOTICE_ADMIN_NO = 0;
	const HOSTING_NOTICE_ADMIN_YES = 1;
	
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
	
	public static function getHostingNoticeUserArray()
	{
		return [
			self::HOSTING_NOTICE_USER_NO => 'Уведомлений не отправлялось',
			self::HOSTING_NOTICE_USER_2W => '2-х недельное уведомление',
			self::HOSTING_NOTICE_USER_2D => '2-х дневное уведомление',
			//self::HOSTING_NOTICE_USER_CREDIT => 'Уведомление о кредите',
		];
	}
	
	public function getHostingNoticeUserValue()
	{
		$statuses = self::getHostingNoticeUserArray();
		return isset($statuses[$this->hosting_notification_user]) ? $statuses[$this->hosting_notification_user] : '';
	}
	
	public static function getHostingNoticeAdminArray()
	{
		return [
			self::HOSTING_NOTICE_ADMIN_NO => 'Уведомлений не отправлялось',
			self::HOSTING_NOTICE_ADMIN_YES => 'Запрос на отключение отправлен',
		];
	}
	
	public function getHostingNoticeAdminValue()
	{
		$statuses = self::getHostingNoticeAdminArray();
		return isset($statuses[$this->hosting_notification_admin]) ? $statuses[$this->hosting_notification_admin] : '';
	}
	
	public static function tableName()
	{
		return 'information';
	}
	
	public function rules()
	{
		return [
			[['hosting_state', 'hosting_face', 'rate'], 'required'],
			[['hosting_state', 'hosting_face', 'rate'], 'integer'],
			['extended_info', 'string'],
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
			'hosting_notification_user' => 'Статус уведомления владельцам',
			'hosting_notification_admin' => 'Статус уведомления администратору',
			'rate' => 'Стоимость',
			'extended_info' => 'Комментарий'
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
