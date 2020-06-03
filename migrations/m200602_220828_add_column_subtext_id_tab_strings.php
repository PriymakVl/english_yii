<?php

use yii\db\Migration;

/**
 * Class m200602_220828_add_column_subtext_id_tab_strings
 */
class m200602_220828_add_column_subtext_id_tab_strings extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('strings', 'subtext_id', 
            $this->integer()->after('text_id')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('strings', 'subtext_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200602_220828_add_column_subtext_id_tab_strings cannot be reverted.\n";

        return false;
    }
    */
}
