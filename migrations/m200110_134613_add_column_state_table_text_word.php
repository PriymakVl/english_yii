<?php

use yii\db\Migration;

/**
 * Class m200110_134613_add_column_state_table_text_word
 */
class m200110_134613_add_column_state_table_text_word extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('text_word', 'state', $this->integer(3)->notNull()->defaultValue(0)->after('id_word'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('text_word', 'state');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200110_134613_add_column_state_table_text_word cannot be reverted.\n";

        return false;
    }
    */
}
