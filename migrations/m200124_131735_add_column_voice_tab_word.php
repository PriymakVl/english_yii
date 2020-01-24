<?php

use yii\db\Migration;

/**
 * Class m200124_131735_add_column_voice_tab_word
 */
class m200124_131735_add_column_voice_tab_word extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('word', 'voice', $this->string()->after('ru')); 
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('word', 'voice');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200124_131735_add_column_voice_tab_word cannot be reverted.\n";

        return false;
    }
    */
}
