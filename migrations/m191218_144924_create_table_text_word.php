<?php

use yii\db\Migration;

/**
 * Class m191218_144924_create_table_text_word
 */
class m191218_144924_create_table_text_word extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('text_word', [
            'id' => $this->primaryKey(),
            'id_text' => $this->integer(),
            'id_word' => $this->integer(),
            'status' => $this->smallInteger(2)->defaultValue(1),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191218_144924_create_table_text_word cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191218_144924_create_table_text_word cannot be reverted.\n";

        return false;
    }
    */
}
