<?php

use yii\db\Schema;
use yii\db\Migration;

class m150720_071111_modify_designation_table extends Migration
{
    public function up()
    {
      $this->alterColumn('{{%designation}}','level_id',Schema::TYPE_STRING);
    }

    public function down()
    {
        echo "m150720_071111_modify_designation_table cannot be reverted.\n";

        return false;
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
