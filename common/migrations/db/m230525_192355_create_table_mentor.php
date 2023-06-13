<?php

use yii\db\Migration;

/**
 * Class m230525_192355_create_table_mentor
 */
class m230525_192355_create_table_mentor extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%mentor}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'organization_id' => $this->integer()->notNull(),
            'organization_member_id' => $this->integer()->null(),
            'rating' => $this->double()->unsigned()->defaultValue(0),
            'is_deleted' => $this->tinyInteger()->notNull()->defaultValue(0)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mentor}}');
    }
}
