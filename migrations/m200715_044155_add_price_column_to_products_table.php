<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%products}}`.
 */
class m200715_044155_add_price_column_to_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%products}}', 'price', $this->decimal(20,8)->notNull()->after('description'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%products}}', 'price');
    }
}
