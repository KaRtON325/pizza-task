<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%currencies}}".
 *
 * @property int $id
 * @property string $name
 * @property string $symbol
 * @property float $rate
 * @property int $is_base
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%currencies}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'symbol', 'rate', 'is_base'], 'required'],
            [['rate'], 'number'],
            [['is_base'], 'integer'],
            [['name', 'symbol'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'symbol' => Yii::t('app', 'Symbol'),
            'rate' => Yii::t('app', 'Rate'),
            'is_base' => Yii::t('app', 'Is Base'),
        ];
    }
}
