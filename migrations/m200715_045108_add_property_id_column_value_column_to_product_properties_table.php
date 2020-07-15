<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%product_properties}}`.
 */
class m200715_045108_add_property_id_column_value_column_to_product_properties_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_properties}}', 'property_id', $this->integer()->notNull()->unsigned()->after('product_id'));
        $this->addColumn('{{%product_properties}}', 'value', $this->string()->notNull()->after('property_id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product_properties}}', 'property_id');
        $this->dropColumn('{{%product_properties}}', 'value');
    }
}
