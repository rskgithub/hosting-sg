<?php

use yii\db\Schema;
use yii\db\Migration;

class m150625_104710_users_log extends Migration
{
	public function safeUp()
	{
		$this->createTable('users_log', [
			'id' => Schema::TYPE_INTEGER . '(11) unsigned NULL AUTO_INCREMENT',
			'user_id' => Schema::TYPE_INTEGER . '(11) unsigned NOT NULL DEFAULT 0',
			'date' => Schema::TYPE_INTEGER . '(11) NOT NULL DEFAULT 0',
			'message' => Schema::TYPE_TEXT,
			'PRIMARY KEY (id)'
		], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
		$this->addForeignKey('FK_users_log_users', 'users_log', 'user_id', 'users', 'id', 'CASCADE', 'RESTRICT');
	}

	public function safeDown()
	{
		$this->dropForeignKey('FK_users_log_users', 'users_log');
		$this->dropTable('users_log');
	}
}
