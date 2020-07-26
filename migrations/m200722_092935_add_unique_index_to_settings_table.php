<?php

use yii\db\Migration;

/**
 * Class m200722_092935_add_unique_index_to_settings_table
 */
class m200722_092935_add_unique_index_to_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'name_unique',
            '{{%settings}}',
            'name',
            1
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('name_unique', '{{%users}}');
    }
}
