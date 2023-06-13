<?php

use yii\db\Migration;

/**
 * Class m230525_192407_create_table_organization_member
 */
class m230525_192407_create_table_organization_member extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%organization_member}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'organization_id' => $this->integer()->notNull(),
            'position' => $this->string(),
            'is_deleted' => $this->tinyInteger()->notNull()->defaultValue(0)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%organization_member}}');
    }
}
