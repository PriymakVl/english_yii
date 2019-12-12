<?php

use yii\db\Migration;

/**
 * Class m191209_145439_table_word
 */
class m191209_145439_table_word extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('word', [
            'id' => $this->primaryKey(),
            'engl' => $this->string()->notNull()->unique(),
            'ru' => $this->string()->notNull(),
            'status' => $this->smallInteger(2)->defaultValue(1),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('word');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191209_145439_table_word cannot be reverted.\n";

        return false;
    }
    */
}
