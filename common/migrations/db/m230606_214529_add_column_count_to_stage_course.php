<?php

use yii\db\Migration;

/**
 * Class m230606_214529_add_column_count_to_stage_course
 */
class m230606_214529_add_column_count_to_stage_course extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%stage_course}}', 'count', $this->integer()->unsigned()->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%stage_course}}', 'count');
    }
}
