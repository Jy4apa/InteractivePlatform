<?php

use yii\db\Migration;

/**
 * Class m230526_220255_create_table_course
 */
class m230526_220255_create_table_course extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%course}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'date_start' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'date_end' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'status' => $this->tinyInteger()->defaultValue(0)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%course}}');
    }
}
