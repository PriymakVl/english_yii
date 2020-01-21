<?php

use yii\db\Migration;

/**
 * Class m200121_135242_create_tab_categories
 */
class m200121_135242_create_tab_categories extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('category', [
        'id' => $this->primaryKey(),
        'name' => $this->string(100)->notNull(),
        'parent_id' => $this->integer()->notNull()->defaultValue(0),
        'status' => $this->smallInteger(2)->defaultValue(1),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('category');;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200121_135242_create_tab_categories cannot be reverted.\n";

        return false;
    }
    */
}
