<?php

use yii\db\Schema;
use yii\db\Migration;

class m160122_225744_create_login_history_table extends Migration
{
    public function safeUp()
    {
       $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
         $this->createTable('{{%login_history}}', [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING . ' NOT NULL',
            'logintime' => Schema::TYPE_INTEGER,
            'sessionid' => Schema::TYPE_STRING . ' NOT NULL',
            'logouttime' => Schema::TYPE_INTEGER,
            
        ], $tableOptions);
    }

    public function down()
    {
        echo "m160122_225744_create_login_history_table cannot be reverted.\n";

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
