<?php

use yii\db\Migration;

/**
 * Class m200111_133133_add_column_state_table_word
 */
class m200111_133133_add_column_state_table_word extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('word', 'state', $this->integer(3)->notNull()->defaultValue(0)->after('ru'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         $this->dropColumn('word', 'state');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200111_133133_add_column_state_table_word cannot be reverted.\n";

        return false;
    }
    */
}
