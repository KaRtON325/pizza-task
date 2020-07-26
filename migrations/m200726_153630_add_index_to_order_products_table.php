<?php

use yii\db\Migration;

/**
 * Class m200726_153630_add_index_to_order_products_table
 */
class m200726_153630_add_index_to_order_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'order_id_index',
            '{{%order_products}}',
            'order_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('order_id_index', '{{%order_products}}');
    }
}
