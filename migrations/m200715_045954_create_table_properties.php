<?php

use yii\db\Migration;

class m200715_045954_create_table_properties extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%properties}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'name' => $this->string()->notNull(),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%properties}}');
    }
}
