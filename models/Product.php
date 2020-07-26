<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

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
 * @property array $prices
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
            [['name', 'image', 'description', 'price'], 'required'],
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
            $currencies = Currency::find()->all();
            return $this->getPrices($currencies);
        };
        unset($fields['price'], $fields['created_at'], $fields['updated_at']);

        return $fields;
    }

    /**
     * {@inheritdoc}
     */
    public function extraFields()
    {
        return ['product_properties' => 'productProperties', 'productProperties.property'];
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
     * @param Currency[] $currencies
     * @param int $quantity
     * @return array
     */
    public function getPrices(array $currencies, int $quantity = 1): array
    {
        $this->prices = [];
        foreach ($currencies as $currency) {
            $this->prices[] = [
                'currency_id' => $currency->id,
                'value' => $this->price * $currency->rate * $quantity,
                'symbol' => $currency->symbol,
                'is_base' => $currency->is_base,
            ];
        }

        return $this->prices;
    }

    /**
     * Returns Product[] fetched by array of cart items
     * @param array $cartProducts
     * @return Product[]
     */
    public static function getProductsByCartItems(array $cartProducts):array {
        $ids = ArrayHelper::map($cartProducts, 'id', 'id');
        return self::find()->where(['id' => $ids])->all();
    }
}
