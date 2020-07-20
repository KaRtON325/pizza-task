<?php

use yii\db\Migration;

/**
 * Class m200719_113646_insert_rows_to_settings_table
 */
class m200719_115122_insert_rows_to_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%settings}}', [
            'name' => 'delivery_price',
            'value' => '10',
            'created_at' => (new \yii\db\Expression('UNIX_TIMESTAMP()')),
            'updated_at' => (new \yii\db\Expression('UNIX_TIMESTAMP()')),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%settings}}', ['name' => 'delivery_price']);
    }
}
