<?php

use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m200719_122120_insert_rows_to_properties_table
 */
class m200719_122120_insert_rows_to_properties_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Yii::$app->db->createCommand()->batchInsert('{{%properties}}', ['name', 'created_at', 'updated_at'], [
            ['Diameter', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['Crust', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
            ['Vegan', (new Expression('UNIX_TIMESTAMP()')), (new Expression('UNIX_TIMESTAMP()'))],
        ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Yii::$app->db->createCommand()->delete('{{%properties}}', ['in', 'name', ['Diameter', 'Crust', 'Vegan']])->execute();
    }
}
