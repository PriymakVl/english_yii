<?php

use yii\db\Migration;

/**
 * Class m200517_192521_tab_create_states
 */
class m200517_192521_tab_create_states extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('states', ['id' => $this->primaryKey(),
 
            'item_id' => $this->integer(),

            'user_id' => $this->integer(),

            'type' => $this->smallInteger(2),
 
            'value' => $this->smallInteger(2)->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('states');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200517_192521_tab_create_states cannot be reverted.\n";

        return false;
    }
    */
}
