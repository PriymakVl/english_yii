<?php

use yii\db\Migration;

/**
 * Class m200429_145527_create_table_phrase
 */
class m200429_145527_create_table_phrase extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->createTable('phrase', [
            'id' => $this->primaryKey(),
            'engl' => $this->string(),
            'ru' => $this->string(),
            'id_text' => $this->integer(),
            'id_sentense' => $this->integer(),
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
        echo "m200429_145527_create_table_phrase cannot be reverted.\n";

        return false;
    }
    */
}
