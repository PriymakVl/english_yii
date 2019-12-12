<?php

use yii\db\Migration;

/**
 * Class m191210_131548_table_sentense
 */
class m191210_131548_table_sentense extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('sentense', [
            'id' => $this->primaryKey(),
            'engl' => $this->string(),
            'ru' => $this->string(),
            'id_text' => $this->integer(),
            'status' => $this->smallInteger(2)->defaultValue(1),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('sentense');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191210_131548_table_sentense cannot be reverted.\n";

        return false;
    }
    */
}
