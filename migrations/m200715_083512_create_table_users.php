<?php

use yii\db\Migration;

class m200715_083512_create_table_users extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%users}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'login' => $this->string()->notNull(),
                'password_hash' => $this->string()->notNull(),
                'email' => $this->string()->notNull(),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%users}}');
    }
}
