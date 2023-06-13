<?php

use yii\db\Migration;

/**
 * Class m230525_181812_create_table_organization
 */
class m230525_181812_create_table_organization extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%organization}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'description' => $this->text(),
            'logo' => $this->string(),
            'address' => $this->string(),
            'location' => $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%organization}}');
    }
}
