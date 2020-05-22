<?php

use yii\db\Migration;

/**
 * Class m200514_172521_change_names_columns_with_id
 */
class m200514_172521_change_names_columns_with_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('words_text', 'id_word', 'word_id');
        $this->renameColumn('words_text', 'id_text', 'text_id');
        $this->renameColumn('sub_strings', 'id_text', 'text_id');
        $this->renameColumn('sub_strings', 'id_sentense', 'str_id');
        $this->renameColumn('strings', 'id_text', 'text_id');
  
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('words_text', 'word_id', 'id_word');
        $this->renameColumn('words_text', 'text_id', 'id_text');
        $this->renameColumn('sub_strings', 'text_id', 'id_text');
        $this->renameColumn('sub_strings', 'str_id', 'id_sentense');
        $this->renameColumn('strings', 'text_id', 'id_text');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200514_172521_change_names_columns_with_id cannot be reverted.\n";

        return false;
    }
    */
}
