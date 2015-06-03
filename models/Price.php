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
			[['value'], 'integer'],
			[['comment'], 'string', 'max' => 255]
		];
	}

	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'value' => 'Value',
			'comment' => 'Comment',
		];
	}

	public function getHostings()
	{
		return $this->hasMany(Hosting::className(), ['rate' => 'id']);
	}
}
