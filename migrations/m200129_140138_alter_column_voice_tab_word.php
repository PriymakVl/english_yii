<?php

use yii\db\Migration;

/**
 * Class m200129_140138_alter_column_voice_tab_word
 */
class m200129_140138_alter_column_voice_tab_word extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('word', 'voice');
        $this->addColumn('word', 'sound_id', $this->integer()->after('ru'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('word', 'sound_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200129_140138_alter_column_voice_tab_word cannot be reverted.\n";

        return false;
    }
    */
}
