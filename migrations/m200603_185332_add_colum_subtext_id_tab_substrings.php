<?php

use yii\db\Migration;

/**
 * Class m200603_185332_add_colum_subtext_id_tab_substrings
 */
class m200603_185332_add_colum_subtext_id_tab_substrings extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->addColumn('sub_strings', 'subtext_id', 
            $this->integer()->after('text_id')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('sub_strings', 'subtext_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200603_185332_add_colum_subtext_id_tab_substrings cannot be reverted.\n";

        return false;
    }
    */
}
