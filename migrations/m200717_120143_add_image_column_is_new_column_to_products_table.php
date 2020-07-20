<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%products}}`.
 */
class m200717_120143_add_image_column_is_new_column_to_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%products}}', 'image', $this->string()->notNull()->after('name'));
        $this->addColumn('{{%products}}', 'is_new', $this->tinyInteger('1')->after('price'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%products}}', 'image');
        $this->dropColumn('{{%products}}', 'is_new');
    }
}
