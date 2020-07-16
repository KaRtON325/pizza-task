<?php

use yii\db\Migration;

/**
 * Class m200715_102620_add_unique_index_to_users_table
 */
class m200715_102620_add_unique_index_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'email_unique',
            '{{%users}}',
            'email',
            1
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('email_unique', '{{%users}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200715_102620_add_unique_index_to_users_table cannot be reverted.\n";

        return false;
    }
    */
}
