<?php

use yii\db\Schema;
use yii\db\Migration;

class m150917_101152_create_options_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%options}}', [
            'id' => Schema::TYPE_PK,
            'name' => 'VARCHAR(255)',
            'value' => Schema::TYPE_TEXT . ' NOT NULL',
            'created_id' => Schema::TYPE_INTEGER . ' UNSIGNED DEFAULT NULL',
            'updated_id' => Schema::TYPE_INTEGER . ' UNSIGNED DEFAULT NULL',
            'created' => SChema::TYPE_INTEGER . ' DEFAULT NULL',
            'updated' => SChema::TYPE_INTEGER . ' DEFAULT NULL',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%options}}');
    }
}
