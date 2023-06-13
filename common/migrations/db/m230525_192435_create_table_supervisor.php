<?php

use yii\db\Migration;

/**
 * Class m230525_192435_create_table_supervisor
 */
class m230525_192435_create_table_supervisor extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%supervisor}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'direction_id' => $this->integer()->notNull(),
            'position' => $this->string(),
            'is_deleted' => $this->tinyInteger()->notNull()->defaultValue(0)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%supervisor}}');
    }
}
