<?php

namespace app\models;

use Yii;

class Price extends \yii\db\ActiveRecord
{
	public static function tableName()
	{
		return 'rates';
	}

	public function rules()
	{
		return [
			['value', 'integer'],
			['comment', 'string', 'max' => 255],
			['value', 'unique', 'targetClass' => self::className(), 'message' => 'Такая стоимость уже есть в базе.'],
		];
	}

	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'value' => 'Стоимость хостинга',
			'comment' => 'Комментарий',
		];
	}

	public function getHostings()
	{
		return $this->hasMany(Hosting::className(), ['rate' => 'id']);
	}
}
