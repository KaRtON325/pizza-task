<?php

use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m200719_122822_insert_rows_to_product_properties_table
 */
class m200719_122822_insert_rows_to_product_properties_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Yii::$app->db->createCommand()->batchInsert('{{%product_properties}}', ['product_id', 'property_id', 'value', 'created_at', 'updated_at'], [
            ['1', '1', '10"', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['1', '2', 'Thin', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['1', '3', 'No', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['2', '1', '14"', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['2', '2', 'Original', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['2', '3', 'Yes', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['3', '1', '12"', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['3', '2', 'Original', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['3', '3', 'No', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['4', '1', '12"', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['4', '2', 'Thin', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['4', '3', 'No', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['5', '1', '10"', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['5', '2', 'Thin', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['5', '3', 'Yes', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['6', '1', '10"', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['6', '2', 'Original', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['6', '3', 'Yes', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['7', '1', '14"', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['7', '2', 'Original', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['7', '3', 'No', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['8', '1', '14"', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['8', '2', 'Original', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['8', '3', 'No', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
        ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Yii::$app->db->createCommand()->delete('{{%properties}}', ['in', 'product_id', ['1', '2', '3', '4', '5', '6', '7', '8']])->execute();
    }
}
