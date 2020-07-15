<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%products_properties}}`.
 */
class m200715_044558_drop_price_column_from_products_properties_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%product_properties}}', 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%product_properties}}', 'name', $this->string());
    }
}
