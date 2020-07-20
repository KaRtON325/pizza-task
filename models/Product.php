<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%products}}".
 *
 * @property int $id
 * @property string $name
 * @property string $image
 * @property string $description
 * @property float $price
 * @property int $created_at
 * @property int $updated_at
 *
 * @property OrderProduct[] $orderProducts
 * @property ProductProperty[] $productProperties
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @var array Prices in existing currencies
     */
    public $prices;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%products}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'image', 'description', 'price', 'created_at', 'updated_at'], 'required'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['created_at', 'updated_at'], 'integer'],
            [['name', 'image'], 'string', 'max' => 255],
            [['prices'], 'safe', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function fields()
    {
        $fields = parent::fields();
        $fields['prices'] = function() {
            return $this->getPrices();
        };
        unset($fields['price'], $fields['created_at'], $fields['updated_at']);

        return $fields;
    }

    /**
     * {@inheritdoc}
     */
    public function extraFields()
    {
        return ['productProperties', 'productProperties.property'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'image' => Yii::t('app', 'Image'),
            'description' => Yii::t('app', 'Description'),
            'price' => Yii::t('app', 'Price'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[OrderProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderProducts()
    {
        return $this->hasMany(OrderProduct::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ProductProperties]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductProperties()
    {
        return $this->hasMany(ProductProperty::class, ['product_id' => 'id']);
    }

    /**
     * Returns prices in existing currencies
     *
     * @return array
     */
    public function getPrices(): array
    {
        $base_currency = Currency::findOne(['is_base' => 1]);
        $base_price = $this->price * $base_currency->rate;
        $this->prices[] = [
            'currency_id' => $base_currency->id,
            'value' => $base_price,
            'symbol' => $base_currency->symbol,
            'is_base' => 1,
        ];

        foreach (Currency::findAll(['is_base' => 0]) as $currency) {
            $this->prices[] = [
                'currency_id' => $currency->id,
                'value' => $base_price * $currency->rate,
                'symbol' => $currency->symbol,
                'is_base' => 0,
            ];
        }

        return $this->prices;
    }
}
