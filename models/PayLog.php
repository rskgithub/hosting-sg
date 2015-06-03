<?php

namespace app\models;

use Yii;

class PayLog extends \yii\db\ActiveRecord
{
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
			'ID' => 'ID',
			'date' => 'Date',
			'user_ID' => 'User  ID',
			'hosting_name' => 'Hosting Name',
			'value' => 'Value',
			'state' => 'State',
		];
	}

	public function getUser()
	{
		return $this->hasOne(Users::className(), ['id' => 'user_ID']);
	}
}
