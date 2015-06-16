<?php

use yii\db\Schema;
use yii\db\Migration;

class m150601_184651_prepare_database extends Migration
{
	public function safeUp()
	{
		$this->alterColumn('users', 'id', Schema::TYPE_INTEGER . '(11) unsigned NOT NULL AUTO_INCREMENT');
		$this->alterColumn('users', 'password', Schema::TYPE_STRING . '(255) NOT NULL');
		$this->alterColumn('users', 'passport', Schema::TYPE_STRING . '(255) NOT NULL');
		$this->alterColumn('users', 'passport_issued', Schema::TYPE_STRING . '(255) NOT NULL');
		$this->alterColumn('users', 'phone', Schema::TYPE_STRING . '(255) NOT NULL');
		$this->alterColumn('users', 'address', Schema::TYPE_STRING . '(255) NOT NULL');
		$this->alterColumn('information_users', 'user_id', Schema::TYPE_INTEGER . '(11) unsigned NOT NULL DEFAULT 0');
		$this->alterColumn('pay_log', 'user_ID', Schema::TYPE_INTEGER . '(11) unsigned NOT NULL DEFAULT 0');
		$this->renameColumn('pay_log', 'domain_ID', 'hosting_name');
		$this->alterColumn('pay_log', 'hosting_name', Schema::TYPE_STRING . '(255) NOT NULL');
		$this->execute('ALTER TABLE `information` ENGINE=InnoDB');
		$this->addColumn('users', 'auth_key', Schema::TYPE_STRING . '(32) NULL DEFAULT NULL AFTER `email`');
		$this->addColumn('users', 'status', Schema::TYPE_SMALLINT . '(1) NOT NULL DEFAULT 0 AFTER `activation_key`');
		$this->addColumn('information', 'hosting_freeze', Schema::TYPE_SMALLINT . '(1) NOT NULL DEFAULT 0 AFTER `hosting_state`');
		$this->renameColumn('information', 'hosting_notification_user', 'notification_user');
		$this->renameColumn('information', 'hosting_notification_admin', 'notification_admin');
		$this->addColumn('information', 'manual_notification', Schema::TYPE_INTEGER . '(11) unsigned NOT NULL DEFAULT 0 AFTER `notification_admin`');
		$this->addForeignKey('FK_information_users_users', 'information_users', 'user_id', 'users', 'id', 'CASCADE', 'RESTRICT');
		$this->addForeignKey('FK_information_users_information', 'information_users', 'information_id', 'information', 'id', 'CASCADE', 'RESTRICT');
		$this->addForeignKey('FK_pay_log_users', 'pay_log', 'user_ID', 'users', 'id', 'CASCADE', 'RESTRICT');
		//
		$this->dropTable('rates');
		$this->createTable('rates', [
			'id' => Schema::TYPE_INTEGER . '(11) unsigned NULL AUTO_INCREMENT',
			'value' => Schema::TYPE_INTEGER . '(11) NOT NULL DEFAULT 0',
			'comment' => Schema::TYPE_STRING . '(255) NULL DEFAULT NULL',
			'PRIMARY KEY (id)'
		], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
		$this->insert('rates', ['id' => 1, 'value' => 3000]);
		$this->insert('rates', ['id' => 2, 'value' => 3150]);
		$this->insert('rates', ['id' => 3, 'value' => 4000]);
		$this->insert('rates', ['id' => 4, 'value' => 8472]);
		//
		$this->dropColumn('information', 'rate');
		$this->addColumn('information', 'rate', Schema::TYPE_INTEGER . '(11) unsigned NULL DEFAULT NULL AFTER `notification_admin`');
		$this->execute('UPDATE `information` SET `rate` = 1 WHERE `paid_till` > 0');
		$this->execute('UPDATE `information` SET `rate` = 2 WHERE `id` IN (11444, 11208)');
		$this->execute('UPDATE `information` SET `rate` = 3 WHERE `id` = 11613');
		$this->execute('UPDATE `information` SET `rate` = 4 WHERE `id` = 11382');
		$this->execute('UPDATE `information` SET `notification_user` = 0, `notification_admin` = 0 WHERE `id` = 11568');
		$this->addForeignKey('FK_information_rates', 'information', 'rate', 'rates', 'id', 'SET NULL', 'RESTRICT');
	}

	public function safeDown()
	{
		$this->dropForeignKey('FK_information_rates', 'information');
		$this->execute('UPDATE `information` SET `notification_user` = 2, `notification_admin` = 1 WHERE `id` = 11568');
		$this->dropColumn('information', 'rate');
		$this->addColumn('information', 'rate', Schema::TYPE_INTEGER . '(1) NOT NULL DEFAULT 1 AFTER `notification_admin`');
		$this->execute('UPDATE `information` SET `rate` = 1');
		$this->execute('UPDATE `information` SET `rate` = 2 WHERE `id` IN (11444, 11208)');
		$this->execute('UPDATE `information` SET `rate` = 3 WHERE `id` = 11613');
		$this->execute('UPDATE `information` SET `rate` = 4 WHERE `id` = 11382');
		//
		$this->dropTable('rates');
		$this->createTable('rates', [
			'id' => Schema::TYPE_INTEGER . '(10) unsigned NOT NULL AUTO_INCREMENT',
			'value' => Schema::TYPE_INTEGER . '(11) NOT NULL',
			'comment' => Schema::TYPE_TEXT . ' NOT NULL',
			'PRIMARY KEY (id)'
		], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
		$this->insert('rates', ['id' => 1, 'value' => 3000]);
		$this->insert('rates', ['id' => 2, 'value' => 3150]);
		$this->insert('rates', ['id' => 3, 'value' => 4000]);
		$this->insert('rates', ['id' => 4, 'value' => 8472]);
		//
		$this->dropForeignKey('FK_pay_log_users', 'pay_log');
		$this->dropForeignKey('FK_information_users_information', 'information_users');
		$this->dropForeignKey('FK_information_users_users', 'information_users');
		$this->dropColumn('information', 'manual_notification');
		$this->renameColumn('information', 'notification_user', 'hosting_notification_user');
		$this->renameColumn('information', 'notification_admin', 'hosting_notification_admin');
		$this->dropColumn('information', 'hosting_freeze');
		$this->dropColumn('users', 'status');
		$this->dropColumn('users', 'auth_key');
		$this->execute('ALTER TABLE `information` ENGINE=MyISAM');
		$this->alterColumn('pay_log', 'hosting_name', Schema::TYPE_INTEGER . '(11) NOT NULL DEFAULT 0');
		$this->renameColumn('pay_log', 'hosting_name', 'domain_ID');
		$this->alterColumn('pay_log', 'user_ID', Schema::TYPE_INTEGER . '(11) NOT NULL DEFAULT 0');
		$this->alterColumn('information_users', 'user_id', Schema::TYPE_INTEGER . '(10) UNSIGNED NOT NULL');
		$this->alterColumn('users', 'address', Schema::TYPE_TEXT . ' NOT NULL');
		$this->alterColumn('users', 'phone', Schema::TYPE_TEXT . ' NOT NULL');
		$this->alterColumn('users', 'passport_issued', Schema::TYPE_TEXT . ' NOT NULL');
		$this->alterColumn('users', 'passport', Schema::TYPE_TEXT . ' NOT NULL');
		$this->alterColumn('users', 'password', Schema::TYPE_STRING . '(64) NOT NULL');
		$this->alterColumn('users', 'id', Schema::TYPE_INTEGER . '(10) unsigned NOT NULL AUTO_INCREMENT');
	}
}
