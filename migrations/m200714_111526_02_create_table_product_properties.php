<?php

use yii\db\Migration;

class m200714_111526_02_create_table_product_properties extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%product_properties}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'product_id' => $this->integer()->unsigned()->notNull(),
                'name' => $this->string()->notNull(),
                'created_at' => $this->integer()->unsigned()->notNull(),
                'updated_at' => $this->integer()->unsigned()->notNull(),
            ],
            $tableOptions
        );

        $this->addForeignKey(
            'fk_product',
            '{{%product_properties}}',
            ['product_id'],
            '{{%products}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%product_properties}}');
    }
}
