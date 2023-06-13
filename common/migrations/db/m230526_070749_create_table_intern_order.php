<?php

use yii\db\Migration;

/**
 * Class m230526_070749_create_table_intern_order
 */
class m230526_070749_create_table_intern_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%intern_order}}', [
            'id' => $this->primaryKey(),
            'intern_id' => $this->integer()->notNull(),
            'vacancy_id' => $this->integer(),
            'status' => $this->tinyInteger()->notNull()->defaultValue(0),
            'evaluate' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'is_deleted' => $this->tinyInteger()->notNull()->defaultValue(0)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%intern_order}}');
    }
}
