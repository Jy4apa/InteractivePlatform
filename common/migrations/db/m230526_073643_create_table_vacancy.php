<?php

use yii\db\Migration;

/**
 * Class m230526_073643_create_table_vacancy
 */
class m230526_073643_create_table_vacancy extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vacancy}}', [
            'id' => $this->primaryKey(),
            'direction_id' => $this->integer(),
            'organization_id' => $this->integer()->notNull(),
            'intern_id' => $this->integer(),
            'mentor_id' => $this->integer(),
            'income' => $this->integer()->unsigned(),
            'title' => $this->string(),
            'address' => $this->string(),
            'geo_lat' => $this->double(),
            'geo_lon' => $this->double(),
            'description' => $this->string(),
            'schedule' => $this->string(),
            'status' => $this->tinyInteger()->notNull(),
            'is_publish' => $this->tinyInteger()->notNull()->defaultValue(0),
            'created_by' => $this->integer(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'is_deleted' => $this->tinyInteger()->notNull()->defaultValue(0)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%vacancy}}');
    }
}
