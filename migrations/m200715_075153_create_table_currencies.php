<?php

use yii\db\Migration;

class m200715_075153_create_table_currencies extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%currencies}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'name' => $this->string()->notNull(),
                'symbol' => $this->string()->notNull(),
                'rate' => $this->decimal(20, 8)->unsigned()->notNull(),
                'is_base' => $this->tinyInteger()->unsigned()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%currencies}}');
    }
}
