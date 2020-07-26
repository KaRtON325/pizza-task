<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%orders}}".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $currency_id
 * @property string $first_name
 * @property string $last_name
 * @property string $address
 * @property string $email
 * @property string $phone_number
 * @property float $total
 * @property float $delivery_price
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Currency $currency
 * @property OrderProduct[] $orderProducts
 * @property User $user
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%orders}}';
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
            [['user_id', 'currency_id', 'created_at', 'updated_at'], 'integer'],
            [['first_name', 'last_name', 'address', 'email', 'phone_number', 'total', 'delivery_price'], 'required'],
            [['total', 'delivery_price'], 'number'],
            [['address'], 'string', 'max' => 1020],
            [['first_name', 'last_name', 'address', 'email', 'phone_number'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::class, 'targetAttribute' => ['currency_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function fields()
    {
        $fields = parent::fields();
        unset($fields['user_id'], $fields['currency_id'], $fields['updated_at']);

        return $fields;
    }

    /**
     * {@inheritdoc}
     */
    public function extraFields()
    {
        return ['order_products' => 'orderProducts', 'orderProducts.product', 'currency'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'currency_id' => Yii::t('app', 'Currency ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'address' => Yii::t('app', 'Address'),
            'email' => Yii::t('app', 'Email'),
            'phone_number' => Yii::t('app', 'Phone Number'),
            'total' => Yii::t('app', 'Total'),
            'delivery_price' => Yii::t('app', 'Delivery Price'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Currency]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::class, ['id' => 'currency_id']);
    }

    /**
     * Gets query for [[OrderProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderProducts()
    {
        return $this->hasMany(OrderProduct::class, ['order_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Calculates total by products
     *
     * @param Product[] $products
     * @param array $quantities Array of shape: [id => quantity]
     * @param Currency $currency
     */
    public static function getTotalByProducts(array $products, array $quantities, Currency $currency):float {
        $total = 0;
        foreach ($products as $product) {
            $total += $product->price * $quantities[$product->id] * $currency->rate;
        }

        return $total;
    }

    /**
     * Returns array with product prices in all currencies,
     * delivery price and totals in all currencies
     *
     * @param array $cartProducts
     * @return array
     */
    public static function getPrices(array $cartProducts): array
    {
        $prices = [
            'products' => [],
            'delivery_prices' => [],
            'totals' => [],
        ];

        /**
         * @var $currencies Currency[]
         */
        $currencies = Currency::find()->all();
        $products = Product::getProductsByCartItems($cartProducts); // Getting array of product objects
        $quantities = ArrayHelper::map($cartProducts, 'id', 'quantity'); // Getting rates array based on currencies
        $base_delivery_price = Setting::getDeliveryPrice(); // Getting base delivery price stated in site settings

        foreach ($products as $product) {
            $quantity = $quantities[$product->id];
            // Multiplying product prices by quantities and calculating order total in all currencies
            $prices['products'][$product->id] = array_merge(
                ['prices' => $product->getPrices($currencies)],
                ['totals' => $product->getPrices($currencies, $quantity)]
            );
        }

        foreach ($currencies as $currency) {
            $delivery_price = $base_delivery_price * $currency->rate;
            $prices['delivery_prices'][] = [
                'value' => $delivery_price,
                'currency_id' => $currency->id,
                'symbol' => $currency->symbol
            ];
            $prices['totals'][] = [
                'value' => self::getTotalByProducts($products, $quantities, $currency) + $delivery_price,
                'currency_id' => $currency->id,
                'symbol' => $currency->symbol
            ];
        }

        return $prices;
    }
}
