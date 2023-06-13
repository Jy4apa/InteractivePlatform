<?php

use yii\db\Migration;

/**
 * Class m230526_144407_create_table_specialization
 */
class m230526_144407_create_table_specialization extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%specialization}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'direction_id' => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%specialization}}');
    }
}
