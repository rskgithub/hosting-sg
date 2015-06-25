<?php

namespace app\models;

use Yii;

class UsersLog extends \yii\db\ActiveRecord
{
	public static function tableName()
	{
		return 'users_log';
	}

	public function rules()
	{
		return [
			[['user_id', 'date', 'message'], 'required'],
			[['user_id', 'date'], 'integer'],
			[['message'], 'string']
		];
	}

	public function attributeLabels()
	{
		return [
			'date' => 'Дата',
			'message' => 'Событие',
		];
	}

	public function getUser()
	{
		return $this->hasOne(Users::className(), ['id' => 'user_id']);
	}
	
	public function logSave($user_id, $message)
	{
		if (intval($user_id) > 0 && !empty($message)) {
			$this->date = time();
			$this->user_id = intval($user_id);
			$this->message = $message;
			if ($this->save())
				return true;
		}
		return false;
	}
}
