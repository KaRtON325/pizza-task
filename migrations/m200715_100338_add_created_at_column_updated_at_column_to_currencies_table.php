<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%currencies}}`.
 */
class m200715_100338_add_created_at_column_updated_at_column_to_currencies_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%currencies}}', 'created_at', $this->integer()->unsigned()->notNull());
        $this->addColumn('{{%currencies}}', 'updated_at', $this->integer()->unsigned()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%currencies}}', 'created_at');
        $this->dropColumn('{{%currencies}}', 'updated_at');
    }
}
