<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m180324_130302_create_table
 */
class m180324_130302_create_table extends Migration
{
    public function up()
    {
        $this->createTable('users', [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING . ' NOT NULL',
			'password' => Schema::TYPE_STRING . ' NOT NULL',
			'ref_key' => Schema::TYPE_STRING . ' NULL DEFAULT NULL',
			'authKey' => Schema::TYPE_STRING . ' NULL DEFAULT NULL',
			'from' => 'int(11) UNSIGNED NULL DEFAULT NULL',
            
        ]);
    }

    public function down()
    {
        $this->dropTable('users');
    }
}
