<?php

use yii\db\Migration;

/**
 * Class m230526_153308_insert_specialization_data
 */
class m230526_153308_insert_specialization_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%specialization}}', [
            'id' => 1,
            'title' => 'HR, управление персоналом',
            'direction_id' => 7
        ]);
        $this->insert('{{%specialization}}', [
            'id' => 2,
            'title' => 'PR, пресс-служба',
            'direction_id' => 2
        ]);
        $this->insert('{{%specialization}}', [
            'id' => 3,
            'title' => 'Администрирование, координация деятельности',
            'direction_id' => 3
        ]);
        $this->insert('{{%specialization}}', [
            'id' => 4,
            'title' => 'Аналитика, экспертиза',
            'direction_id' => 5
        ]);
        $this->insert('{{%specialization}}', [
            'id' => 5,
            'title' => 'Безопасность',
            'direction_id' => 5
        ]);
        $this->insert('{{%specialization}}', [
            'id' => 6,
            'title' => 'Бухгалтерия',
            'direction_id' => 6
        ]);
        $this->insert('{{%specialization}}', [
            'id' => 7,
            'title' => 'Государственные закупки',
            'direction_id' => 6
        ]);
        $this->insert('{{%specialization}}', [
            'id' => 8,
            'title' => 'Документооборот',
            'direction_id' => 5
        ]);
        $this->insert('{{%specialization}}', [
            'id' => 9,
            'title' => 'Информационные технологии',
            'direction_id' => 1
        ]);
        $this->insert('{{%specialization}}', [
            'id' => 10,
            'title' => 'Консалтинг',
            'direction_id' => 6
        ]);
        $this->insert('{{%specialization}}', [
            'id' => 11,
            'title' => 'Контроль и аудит',
            'direction_id' => 7
        ]);
        $this->insert('{{%specialization}}', [
            'id' => 12,
            'title' => 'Корпоративные коммуникации',
            'direction_id' => 3
        ]);
        $this->insert('{{%specialization}}', [
            'id' => 13,
            'title' => 'Медицина',
            'direction_id' => 3
        ]);
        $this->insert('{{%specialization}}', [
            'id' => 14,
            'title' => 'Прием граждан',
            'direction_id' => 3
        ]);
        $this->insert('{{%specialization}}', [
            'id' => 15,
            'title' => 'Финансы',
            'direction_id' => 6
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }
}
