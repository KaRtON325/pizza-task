<?php

use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m200719_110008_insert_rows_to_products_table
 */
class m200719_110008_insert_rows_to_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Yii::$app->db->createCommand()->batchInsert('{{%products}}', ['name', 'image', 'description', 'price', 'created_at', 'updated_at'], [
            ['Cheese & Tomato', '/i/pizzas/margarita.png', 'Marinara sauce, cherry tomatoes, extra mozzarella, oregano', 12, (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['4 Seasons', '/i/pizzas/4seasons.png', 'Marinara sauce, mushrooms, extra mozzarella, ham', 15, (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['4 Cheese', '/i/pizzas/4cheese.png', 'Creamy sauce, cheddar, blue cheese, mozzarella cheese, hard cheese', 14.9, (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['Pepperoni', '/i/pizzas/pepperoni.png', 'Pepperoni, marinara sauce, extra mozzarella', 12.9, (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['Cheeseburger', '/i/pizzas/cheeseburger.png', 'Cheeseburger sauce, cheddar', 12.99, (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['Italian', '/i/pizzas/italian.png', 'Сhilli pepper, onion red, pepper bell, mozzarella cheese', 13.5, (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['Farmhouse', '/i/pizzas/farmhouse.png', 'Marinara sauce, mushrooms, extra mozzarella, ham', 14.59, (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['Hawaiian', '/i/pizzas/hawaiian.png', 'Ham, extra mozzarella, marinara sauce, pineapple', 14, (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
        ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Yii::$app->db->createCommand()->delete('{{%products}}', ['in', 'name', ['Cheese & Tomato', '4 Seasons', '4 Cheese', 'Pepperoni', 'Cheeseburger', 'Italian', 'Farmhouse', 'Hawaiian']])->execute();
    }
}
