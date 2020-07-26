<?php

use yii\db\Migration;

/**
 * Class m200726_153336_add_index_to_currencies_table
 */
class m200726_153336_add_index_to_currencies_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'is_base_index',
            '{{%currencies}}',
            'is_base',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('is_base_index', '{{%currencies}}');
    }
}
