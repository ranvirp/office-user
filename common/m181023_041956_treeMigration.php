<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m181023_041956_treeMigration
 */
class m181023_041956_treeMigration extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        ob_start();
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // tree
        if ($this->db->getTableSchema('{{%tree}}', true) !== null) {
            $this->dropTable('{{%tree}}');
        }
        $this->createTable('{{%tree}}', [
            'id'    => Schema::TYPE_PK,
            'lft'   => Schema::TYPE_INTEGER . ' NOT NULL',
            'rgt'   => Schema::TYPE_INTEGER . ' NOT NULL',
            'depth' => Schema::TYPE_INTEGER . ' NOT NULL',
            'slug'  => Schema::TYPE_STRING . ' NOT NULL',
        ], $tableOptions);
        $this->createIndex('lft1', '{{%tree}}', ['lft', 'rgt']);
        $this->createIndex('rgt1', '{{%tree}}', ['rgt']);

        // multiple tree
        if ($this->db->getTableSchema('{{%multiple_tree}}', true) !== null) {
            $this->dropTable('{{%multiple_tree}}');
        }
        $this->createTable('{{%multiple_tree}}', [
            'id'    => Schema::TYPE_PK,
            'tree'  => Schema::TYPE_INTEGER . ' NULL',
            'lft'   => Schema::TYPE_INTEGER . ' NOT NULL',
            'rgt'   => Schema::TYPE_INTEGER . ' NOT NULL',
            'depth' => Schema::TYPE_INTEGER . ' NOT NULL',
            'slug'  => Schema::TYPE_STRING . ' NOT NULL',
        ], $tableOptions);
        $this->createIndex('lft2', '{{%multiple_tree}}', ['tree', 'lft', 'rgt']);
        $this->createIndex('rgt2', '{{%multiple_tree}}', ['tree', 'rgt']);

        // update cache (sqlite bug)
        $this->db->getSchema()->getTableSchema('{{%tree}}', true);
        $this->db->getSchema()->getTableSchema('{{%multiple_tree}}', true);
        ob_end_clean();
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181023_041956_treeMigration cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181023_041956_treeMigration cannot be reverted.\n";

        return false;
    }
    */
}
