<?php

use yii\db\Schema;
use yii\db\Migration;

class m150909_103349_create_posts_table extends Migration
{
    public function up()
    {
	return $this->createTable('posts', array(
    		'id' => 'INT PRIMARY KEY AUTO_INCREMENT',
    		'title' => 'VARCHAR(255)',
    		'data' => 'TEXT',
    		'create_time' => 'INT',
    		'update_time' => 'INT'
    	));
    }

    public function down()
    {
        //echo "m150909_103349_create_posts_table cannot be reverted.\n";
        //return false;
	return $this->dropTable('posts');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
