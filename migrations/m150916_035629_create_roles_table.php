<?php

use yii\db\Schema;
use yii\db\Migration;

class m150916_035629_create_roles_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%roles}}', [
            'id' => Schema::TYPE_PK,
            'name' => 'VARCHAR(255)',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%roles}}');
    }
}
