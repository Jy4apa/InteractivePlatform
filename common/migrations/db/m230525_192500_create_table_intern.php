<?php

use yii\db\Migration;

/**
 * Class m230525_192500_create_table_intern
 */
class m230525_192500_create_table_intern extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%intern}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'is_deleted' => $this->tinyInteger()->notNull()->defaultValue(0)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%intern}}');
    }
}
