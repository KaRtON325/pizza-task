<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%currencies}}".
 *
 * @property int $id
 * @property string $name
 * @property string $symbol
 * @property float $rate Multiplier for the base currency
 * @property int $is_base Sets the base currency that will be used to calculate price in other currencies
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Order[] $orders
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
    public function behaviors() {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'symbol', 'rate', 'is_base'], 'required'],
            [['rate'], 'number'],
            [['is_base', 'created_at', 'updated_at'], 'integer'],
            [['name', 'symbol'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function fields()
    {
        $fields = parent::fields();
        unset($fields['created_at'], $fields['updated_at']);

        return $fields;
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
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['currency_id' => 'id']);
    }
}
