<?php

use yii\db\Schema;
use yii\db\Migration;

class m150729_041455_modify_website_management_table extends Migration
{
    public function safeUp()
    {
      $this->update('{{%websitemanagement}}',['code'=>'1'],['id'=>1]);
      $this->dropColumn('{{%websitemanagement}}','id');
      $this->addPrimaryKey('web_pk','{{%websitemanagement}}','code');
    }

    public function down()
    {
        echo "m150729_041455_modify_website_management_table cannot be reverted.\n";

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
