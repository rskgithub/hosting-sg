<?php

namespace app\models;

use Yii;

class PayLog extends \yii\db\ActiveRecord
{
	const PAY_STATUS_FAIL = 0;
	const PAY_STATUS_GOOD = 1;
	
	public static function getPayStatusesArray()
	{
		return [
			self::PAY_STATUS_FAIL => 'Не выполнено',
			self::PAY_STATUS_GOOD => 'Проведён',
		];
	}
	
	public function getPayStatusesValue()
	{
		$statuses = self::getPayStatusesArray();
		return isset($statuses[$this->state]) ? $statuses[$this->state] : '';
	}
	
	public static function tableName()
	{
		return 'pay_log';
	}

	public function rules()
	{
		return [
			[['date', 'user_ID', 'value', 'state'], 'integer'],
			[['hosting_name'], 'required'],
			[['hosting_name'], 'string', 'max' => 255]
		];
	}

	public function attributeLabels()
	{
		return [
			'ID' => 'ID транзакции',
			'date' => 'Дата',
			'user_ID' => 'Пользователь',
			'hosting_name' => 'Хостинг',
			'value' => 'Сумма',
			'state' => 'Статус',
		];
	}

	public function getUser()
	{
		return $this->hasOne(Users::className(), ['id' => 'user_ID']);
	}
}
