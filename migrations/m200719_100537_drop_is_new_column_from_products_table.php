<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%products}}`.
 */
class m200719_100537_drop_is_new_column_from_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%products}}', 'is_new');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%products}}', 'is_new', $this->tinyInteger(1));
    }
}
