<?php

use yii\db\Migration;

/**
 * Class m200509_153749_change_table_text_add_column_sourses
 */
class m200509_153749_change_table_text_add_column_sourses extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('text', 'ref', $this->string()->after('ru')); 
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('text', 'ref');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200509_153749_change_table_text_add_column_sourses cannot be reverted.\n";

        return false;
    }
    */
}
