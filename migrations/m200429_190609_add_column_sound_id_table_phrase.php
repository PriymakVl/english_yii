<?php

use yii\db\Migration;

/**
 * Class m200429_190609_add_column_sound_id_table_phrase
 */
class m200429_190609_add_column_sound_id_table_phrase extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('phrase', 'sound_id', $this->integer()->after('id_text'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('phrase', 'sound_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200429_190609_add_column_sound_id_table_phrase cannot be reverted.\n";

        return false;
    }
    */
}
