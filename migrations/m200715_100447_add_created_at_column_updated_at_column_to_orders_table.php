<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%orders}}`.
 */
class m200715_100447_add_created_at_column_updated_at_column_to_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%orders}}', 'created_at', $this->integer()->unsigned()->notNull());
        $this->addColumn('{{%orders}}', 'updated_at', $this->integer()->unsigned()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%orders}}', 'created_at');
        $this->dropColumn('{{%orders}}', 'updated_at');
    }
}
