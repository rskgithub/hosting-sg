<?php

namespace app\models;

use Yii;

class Hosting extends \yii\db\ActiveRecord
{
	const HOSTING_STATUS_OFF = 0;
	const HOSTING_STATUS_ON = 1;
	
	const HOSTING_FREEZE_OFF = 0;
	const HOSTING_FREEZE_ON = 1;
	
	const HOSTING_FACE_UR = 0;
	const HOSTING_FACE_FIZ = 1;
	
	const HOSTING_NOTICE_USER_NO = 0;
	const HOSTING_NOTICE_USER_2W = 1;
	const HOSTING_NOTICE_USER_2D = 2;
	const HOSTING_NOTICE_USER_S_FREEZE = 3;
	const HOSTING_NOTICE_USER_F_FREEZE = 4;
	
	const HOSTING_NOTICE_ADMIN_NO = 0;
	const HOSTING_NOTICE_ADMIN_S_FREEZE = 1;
	const HOSTING_NOTICE_ADMIN_YES = 2;
	const HOSTING_NOTICE_ADMIN_F_FREEZE = 3;
	
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
	
	public static function getHostingFreezesArray()
	{
		return [
			self::HOSTING_FREEZE_OFF => 'Нет',
			self::HOSTING_FREEZE_ON => 'Да',
		];
	}
	
	public function getHostingFreezesValue()
	{
		$statuses = self::getHostingFreezesArray();
		return isset($statuses[$this->hosting_freeze]) ? $statuses[$this->hosting_freeze] : '';
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
			self::HOSTING_NOTICE_USER_S_FREEZE => 'Уведомление об активации заморозки',
			self::HOSTING_NOTICE_USER_F_FREEZE => 'Уведомление об окончании заморозки',
		];
	}
	
	public function getHostingNoticeUserValue()
	{
		$statuses = self::getHostingNoticeUserArray();
		return isset($statuses[$this->notification_user]) ? $statuses[$this->notification_user] : '';
	}
	
	public static function getHostingNoticeAdminArray()
	{
		return [
			self::HOSTING_NOTICE_ADMIN_NO => 'Уведомлений не отправлялось',
			self::HOSTING_NOTICE_ADMIN_S_FREEZE => 'Уведомление об активации заморозки',
			self::HOSTING_NOTICE_ADMIN_YES => 'Запрос на отключение отправлен',
			self::HOSTING_NOTICE_ADMIN_F_FREEZE => 'Уведомление об окончании заморозки',
		];
	}
	
	public function getHostingNoticeAdminValue()
	{
		$statuses = self::getHostingNoticeAdminArray();
		return isset($statuses[$this->notification_admin]) ? $statuses[$this->notification_admin] : '';
	}
	
	public static function tableName()
	{
		return 'information';
	}
	
	public function rules()
	{
		return [
			[['hosting_state', 'hosting_freeze', 'paid_till', 'hosting_face', 'rate'], 'required'],
			[['hosting_state', 'hosting_freeze', 'hosting_face', 'rate'], 'integer'],
			['paid_till', 'date', 'format' => 'dd.MM.yyyy'],
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
			'hosting_freeze' => 'Заморозка',
			'hosting_face' => 'Лицо',
			'notification_user' => 'Статус уведомления владельцам',
			'notification_admin' => 'Статус уведомления администратору',
			'manual_notification' => 'Ручное уведомление',
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
	
	public function beforeSave($insert)
	{
		$this->paid_till = strtotime($this->paid_till.' 01:00');
		return parent::beforeSave($insert);
	}
	
	public function sendNotification($type, $user_type)
	{
		if ($user_type == 'admin') {
			$messages = [];
			$html = ($type == 'adm_freeze_s') ? 'hostingAdminFreezeNotification-html' : 'hostingAdminNotification-html';
			$from = [Yii::$app->params['supportEmail'] => 'SalesGeneration'];
			//$to = [Yii::$app->params['adminEmail'], Yii::$app->params['supportEmail']];
			$to = ['nordway88@gmail.com', 'theicesun@yandex.ru'];
			$subject = ($type == 'adm_freeze_s') ? '[Хостинг] Активация заморозки для хостинга' : '[Хостинг] Просрочена оплата для хостинга';
			
			if (Yii::$app->mailer->compose(['html' => $html], ['user' => $owner, 'hosting' => $this])->setFrom($from)->setTo($to)->setSubject($subject)->send()) {
				return true;
			}
			
			return false;
		} else {
			$arOwners = $this->getUsers()->all();
			
			if ($arOwners) {
				$messages = [];
				$from = [Yii::$app->params['supportEmail'] => 'SalesGeneration'];
				$subject = 'Уведомление о приближающемся сроке оплаты хостинга';
				
				if ($this->hosting_face == 0) {
					//$to = Yii::$app->params['supportEmail'];
					$to = ['nordway88@gmail.com', 'theicesun@yandex.ru'];
					$messages[] = Yii::$app->mailer->compose(['html' => 'hostingNotification-html'], ['user' => $owner, 'hosting' => $this])->setFrom($from)->setTo($to)->setSubject($subject);
				} else {
					foreach ($arOwners as $owner) {
						//$to = $owner->email;
						$to = ['nordway88@gmail.com', 'theicesun@yandex.ru'];
						$messages[] = Yii::$app->mailer->compose(['html' => 'hostingNotification-html'], ['user' => $owner, 'hosting' => $this])->setFrom($from)->setTo($to)->setSubject($subject);
					}
				}
				
				if (Yii::$app->mailer->sendMultiple($messages) > 0) {
					if ($type == 'manual')
						$this->updateAttributes(['manual_notification' => time()]);
						
					return true;
				}
			}
			
			return false;
		}
	}
}
