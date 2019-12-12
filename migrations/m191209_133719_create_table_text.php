<?php

use yii\db\Migration;

/**
 * Class m191209_133719_create_table_text
 */
class m191209_133719_create_table_text extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('text', [
            'id' => $this->primaryKey(),
            'engl' => $this->text(),
            'ru' => $this->text(),
            'created' => $this->date(),
            'status' => $this->smallInteger(2)->defaultValue(1),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('text');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191209_133719_create_table_text cannot be reverted.\n";

        return false;
    }
    */
}
