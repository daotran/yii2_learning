<?php

use yii\db\Schema;
use yii\db\Migration;

class m150916_041723_create_users_roles_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%users_roles}}', [
            'id' => Schema::TYPE_PK,
        ], $tableOptions);

        $this->addColumn('{{%users_roles}}','user_id',Schema::TYPE_INTEGER.' NOT NULL');
        $this->addForeignKey('fk_users_roles_user_id', '{{%users_roles}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'CASCADE');     
        $this->addColumn('{{%users_roles}}','role_id',Schema::TYPE_INTEGER.' NOT NULL');
        $this->addForeignKey('fk_users_roles_role_id', '{{%users_roles}}', 'role_id', '{{%roles}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_status_user_id','{{%users_roles}}');
        $this->dropForeignKey('fk_status_role_id','{{%users_roles}}');
        $this->dropColumn('{{%users_roles}}','user_id');
        $this->dropColumn('{{%users_roles}}','role_id');
    }
}
