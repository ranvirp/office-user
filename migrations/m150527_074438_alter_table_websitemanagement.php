<?php

use yii\db\Schema;
use yii\db\Migration;

class m150527_074438_alter_table_websitemanagement extends Migration
{
    public function up()
    {
//$this->addColumn('{{%websitemanagement}}','code',Schema::TYPE_STRING." default 'webadmin'"); 
    }

    public function down()
    {
        echo "m150527_074438_alter_table_websitemanagement cannot be reverted.\n";

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
