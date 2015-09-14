<?php

use yii\db\Schema;
use yii\db\Migration;

class m150914_075138_create_users_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%users}}', [
            'id' => Schema::TYPE_PK,
            'first_name' => 'VARCHAR(255)',
            'last_name' => 'VARCHAR(255)',
            'email' => 'VARCHAR(255)',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%users}}');
    }
}
