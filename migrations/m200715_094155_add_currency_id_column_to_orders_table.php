<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%orders}}`.
 */
class m200715_094155_add_currency_id_column_to_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%orders}}', 'currency_id', $this->integer()->unsigned()->after('user_id'));
        $this->addForeignKey(
            'fk_currency',
            '{{%orders}}',
            ['currency_id'],
            '{{%currencies}}',
            ['id'],
            'SET NULL',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%orders}}', 'base_currency');
    }
}
