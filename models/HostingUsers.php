<?php

namespace app\models;

use Yii;

class HostingUsers extends \yii\db\ActiveRecord
{
	public static function tableName()
	{
		return 'information_users';
	}

	public function rules()
	{
		return [
			[['information_id', 'user_id'], 'required'],
			[['information_id', 'user_id'], 'integer']
		];
	}

	public function attributeLabels()
	{
		return [
			'information_id' => 'Information ID',
			'user_id' => 'User ID',
		];
	}

	public function getHosting()
	{
		return $this->hasOne(Hosting::className(), ['id' => 'information_id']);
	}

	public function getUser()
	{
		return $this->hasOne(Users::className(), ['id' => 'user_id']);
	}
}
