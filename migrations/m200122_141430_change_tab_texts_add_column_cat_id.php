<?php

use yii\db\Migration;

/**
 * Class m200122_141430_change_tab_texts_add_column_cat_id
 */
class m200122_141430_change_tab_texts_add_column_cat_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('text', 'cat_id', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('text', 'cat_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200122_141430_change_tab_texts_add_column_cat_id cannot be reverted.\n";

        return false;
    }
    */
}
