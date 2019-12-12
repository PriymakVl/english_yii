<?php

use yii\db\Migration;

/**
 * Class m191209_141804_add_column_title_table_text
 */
class m191209_141804_add_column_title_table_text extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('text', 'title', $this->string()->notNull()->after('id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('text', 'title');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191209_141804_add_column_title_table_text cannot be reverted.\n";

        return false;
    }
    */
}
