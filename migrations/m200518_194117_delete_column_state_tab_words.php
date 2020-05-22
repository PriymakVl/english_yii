<?php

use yii\db\Migration;

/**
 * Class m200518_194117_delete_column_state_tab_words
 */
class m200518_194117_delete_column_state_tab_words extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('words', 'state');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('words', 'state', $this->integer());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200518_194117_delete_column_state_tab_words cannot be reverted.\n";

        return false;
    }
    */
}
