<?php

use yii\db\Migration;

/**
 * Class m200127_133343_add_table_sound
 */
class m200127_133343_add_table_sound extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('sound', [
            'id' => $this->primaryKey(),
            'type' => $this->smallInteger(5)->notNull(),
            'item_id' => $this->integer()->notNull(),
            'filename' => $this->string(100)->notNull()->unique(),
            'status' => $this->smallInteger(2)->defaultValue(1),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('sound');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200127_133343_add_table_sound cannot be reverted.\n";

        return false;
    }
    */
}
