<?php

use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m200719_124209_insert_rows_to_banners_table
 */
class m200719_124209_insert_rows_to_banners_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Yii::$app->db->createCommand()->batchInsert('{{%banners}}', ['image', 'link', 'created_at', 'updated_at'], [
            ['/i/banners/pizzas_italian_restaurants.jpg', '#product-4', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['/i/banners/pizza-hut-1110x500.jpg', '/about', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
        ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Yii::$app->db->createCommand()->delete('{{%banners}}', ['in', 'image', ['/i/banners/pizzas_italian_restaurants.jpg', '/i/banners/pizza-hut-1110x500.jpg']])->execute();
    }
}
