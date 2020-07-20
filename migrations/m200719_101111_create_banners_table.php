<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%banners}}`.
 */
class m200719_101111_create_banners_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%banners}}', [
            'id' => $this->primaryKey()->unsigned(),
            'image' => $this->string()->notNull(),
            'link' => $this->string(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%banners}}');
    }
}
