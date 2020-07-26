<?php

use yii\db\Migration;

/**
 * Class m200725_120054_alter_access_token_column_from_users_table
 */
class m200725_120054_alter_access_token_column_from_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%users}}', 'access_token', 'string');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%users}}', 'access_token', 'string not null');
    }
}
