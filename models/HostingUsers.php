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
			[['information_id', 'user_id'], 'integer'],
			[['information_id', 'user_id'], 'unique', 'targetAttribute' => ['information_id', 'user_id'], 'message' => 'Выбранный хостинг уже привязан к этому пользователю.']
		];
	}

	public function attributeLabels()
	{
		return [
			'information_id' => 'Выберите хостинг',
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
