<?php

use yii\db\Migration;

/**
 * Class m200726_153516_add_index_to_orders_table
 */
class m200726_153516_add_index_to_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'user_id_index',
            '{{%orders}}',
            'user_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('user_id_index', '{{%orders}}');
    }
}
