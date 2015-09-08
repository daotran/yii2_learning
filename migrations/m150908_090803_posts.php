<?php

use yii\db\Schema;

class m150908_090803_posts extends \yii\db\Migration
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
        //echo "m150908_090803_posts cannot be reverted.\n";
    	//return false;
    	return $this->dropTable('posts');
    }
}