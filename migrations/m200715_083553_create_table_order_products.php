<?php

use yii\db\Migration;

class m200715_083553_create_table_order_products extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%order_products}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'order_id' => $this->integer()->unsigned()->notNull(),
                'product_id' => $this->integer()->unsigned()->notNull(),
                'quantity' => $this->integer()->unsigned()->notNull(),
            ],
            $tableOptions
        );

        $this->addForeignKey(
            'fk_order',
            '{{%order_products}}',
            ['order_id'],
            '{{%orders}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_orders_product',
            '{{%order_products}}',
            ['product_id'],
            '{{%products}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%order_products}}');
    }
}
