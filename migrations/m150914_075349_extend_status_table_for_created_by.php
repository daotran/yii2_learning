<?php

use yii\db\Schema;
use yii\db\Migration;

class m150914_075349_extend_status_table_for_created_by extends Migration
{
    public function up()
    {
      $tableOptions = null;
      if ($this->db->driverName === 'mysql') {
          $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
      }
      $this->addColumn('{{%status}}','created_by',Schema::TYPE_INTEGER.' NOT NULL');
      $this->addForeignKey('fk_status_created_by', '{{%status}}', 'created_by', '{{%users}}', 'id', 'CASCADE', 'CASCADE');     
    }
 
    public function down()
    {
      $this->dropForeignKey('fk_status_created_by','{{%status}}');
      $this->dropColumn('{{%status}}','created_by');
    }
}
