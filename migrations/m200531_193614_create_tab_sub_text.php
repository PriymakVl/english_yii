<?php

use yii\db\Migration;

/**
 * Class m200531_193614_create_tab_sub_text
 */
class m200531_193614_create_tab_sub_text extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('sub_texts', [
 
        'id' => $this->primaryKey(),
 
        'engl' => $this->text(),
 
        'ru' => $this->text(),

        'text_id' => $this->integer()->notNull(),
 
        'state' => $this->smallInteger(2)->defaultValue(0),
 
        'status' => $this->smallInteger(2)->defaultValue(1),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('sub_texts');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200531_193614_create_tab_sub_text cannot be reverted.\n";

        return false;
    }
    */
}
