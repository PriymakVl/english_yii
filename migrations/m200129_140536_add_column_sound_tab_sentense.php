<?php

use yii\db\Migration;

/**
 * Class m200129_140536_add_column_sound_tab_sentense
 */
class m200129_140536_add_column_sound_tab_sentense extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('sentense', 'sound_id', $this->integer()->after('id_text'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('sentense', 'sound_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200129_140536_add_column_sound_tab_sentense cannot be reverted.\n";

        return false;
    }
    */
}
