<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%users}}`.
 */
class m200715_102421_drop_login_column_from_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%users}}', 'login');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%users}}', 'login', $this->string()->notNull());
    }
}
