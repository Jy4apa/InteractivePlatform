<?php

use yii\db\Migration;

/**
 * Class m230527_152318_create_tables_education_and_experience
 */
class m230527_152318_create_tables_education_and_experience extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%education}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'level' => $this->integer(),
            'name' => $this->string(),
            'address' => $this->string(),
            'city' => $this->string(),
            'speciality' => $this->string(),
            'date_start' => $this->integer(),
            'date_end' => $this->integer(),
        ]);

        $this->createTable('{{%experience}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'income' => $this->double(),
            'date_start' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'date_end' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'name' => $this->string(),
            'post' => $this->string(),
            'responsibilities' => $this->text(),
            'key_skills' => $this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%education}}');
        $this->dropTable('{{%experience}}');
    }
}
