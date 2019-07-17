<?php

use yii\db\Migration;

/**
 * Class m190604_121532_new_table
 */
class m190604_121532_new_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190604_121532_new_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190604_121532_new_table cannot be reverted.\n";

        return false;
    }
    */
}
