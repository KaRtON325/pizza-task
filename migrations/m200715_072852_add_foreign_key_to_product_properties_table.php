<?php

use yii\db\Migration;

/**
 * Class m200715_072852_add_foreign_key_to_product_properties_table
 */
class m200715_072852_add_foreign_key_to_product_properties_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fk_property', '{{%product_properties}}', 'property_id', '{{%properties}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%product_properties}}', 'fk_property');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200715_072852_add_foreign_key_to_product_properties_table cannot be reverted.\n";

        return false;
    }
    */
}
