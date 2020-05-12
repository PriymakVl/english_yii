<?php

use yii\db\Migration;

/**
 * Class m200512_172252_change_tab_phrases_column_engl_ru_not_null
 */
class m200512_172252_change_tab_phrases_column_engl_ru_not_null extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('phrase', 'engl', 'string NOT NULL');
        $this->alterColumn('phrase', 'ru', 'string NOT NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "down not code.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200512_172252_change_tab_phrases_column_engl_ru_not_null cannot be reverted.\n";

        return false;
    }
    */
}
