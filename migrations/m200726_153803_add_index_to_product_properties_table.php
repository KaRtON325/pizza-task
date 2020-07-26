<?php

use yii\db\Migration;

/**
 * Class m200726_153803_add_index_to_product_properties_table
 */
class m200726_153803_add_index_to_product_properties_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'product_id_index',
            '{{%product_properties}}',
            'product_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('product_id_index', '{{%product_properties}}');
    }
}
