<?php

use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m200719_123630_insert_rows_to_currencies_table
 */
class m200719_123630_insert_rows_to_currencies_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Yii::$app->db->createCommand()->batchInsert('{{%currencies}}', ['name', 'symbol', 'rate', 'is_base', 'created_at', 'updated_at'], [
            ['Dollar', '$', '1', '1', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['Euro', '€', '1.14', '0', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
        ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Yii::$app->db->createCommand()->delete('{{%currencies}}', ['in', 'name', ['Dollar', 'Euro']])->execute();
    }
}
