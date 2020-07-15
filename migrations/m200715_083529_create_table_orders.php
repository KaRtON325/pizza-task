<?php

use yii\db\Migration;

class m200715_083529_create_table_orders extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%orders}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'user_id' => $this->integer()->unsigned(),
                'first_name' => $this->string()->notNull(),
                'last_name' => $this->string()->notNull(),
                'address' => $this->string()->notNull(),
                'email' => $this->string()->notNull(),
                'phone_number' => $this->string()->notNull(),
                'total' => $this->decimal(20, 8)->unsigned()->notNull(),
                'delivery_price' => $this->decimal(20, 8)->unsigned()->notNull(),
            ],
            $tableOptions
        );

        $this->addForeignKey(
            'fk_user',
            '{{%orders}}',
            ['user_id'],
            '{{%users}}',
            ['id'],
            'SET NULL',
            'SET NULL'
        );
    }

    public function down()
    {
        $this->dropTable('{{%orders}}');
    }
}
