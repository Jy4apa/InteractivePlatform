<?php

use common\models\User;
use yii\db\Migration;

class m140703_123000_user extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(32),
            'email' => $this->string()->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'access_token' => $this->string(40)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'oauth_client' => $this->string(),
            'oauth_client_user_id' => $this->string(),
            'status' => $this->smallInteger()->notNull()->defaultValue(User::STATUS_ACTIVE),
            'referral_link' => $this->string()->defaultValue(''),
            'is_referral_link_available' => $this->tinyInteger()->notNull()->defaultValue('0'),
            'verification_status' => $this->tinyInteger()->notNull()->defaultValue('0'),
            'parent_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'logged_at' => $this->integer()
        ]);

        $this->createTable('{{%user_profile}}', [
            'user_id' => $this->primaryKey(),
            'firstname' => $this->string(),
            'middlename' => $this->string(),
            'position' => $this->string()->null(),
            'lastname' => $this->string(),
            'age' => $this->dateTime()->null(),
            'city' => $this->string(),
            'full_address' => $this->string()->null(),
            'avatar' => $this->string()->defaultValue('/storage/source/user/default_avatar.png'),
            'locale' => $this->string(32)->notNull()->defaultValue('ru-RU'),
            'gender' => $this->smallInteger(1),
            'phone' => $this->string(),
            'country_id' => $this->integer()->null(),
            'role' => $this->integer()->defaultValue(0),
            'scores' => $this->integer()->defaultValue(0)
        ]);

        $this->addForeignKey('fk_user', '{{%user_profile}}', 'user_id', '{{%user}}', 'id', 'cascade', 'cascade');

    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_user', '{{%user_profile}}');
        $this->dropTable('{{%user_profile}}');
        $this->dropTable('{{%user}}');

    }
}
