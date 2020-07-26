<?php

use yii\db\Migration;

/**
 * Class m200722_140234_alter_address_column_from_orders_table
 */
class m200722_140234_alter_address_column_from_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%orders}}', 'address', 'varchar(1020) not null');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%orders}}', 'address', 'string not null');
    }
}
