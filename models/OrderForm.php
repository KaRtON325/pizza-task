<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for order form.
 *
 * @property int|null $user_id
 * @property int|null $currency_id
 * @property string $first_name
 * @property string $last_name
 * @property string $address
 * @property string $email
 * @property string $phone_number
 * @property string $products
 *
 * @property Currency $currency
 */
class OrderForm extends Model {

    /**
     * @var string
     */
    public $first_name;

    /**
     * @var string
     */
    public $last_name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $phone_number;

    /**
     * @var string
     */
    public $address;

    /**
     * @var int
     */
    public $currency_id;

    /**
     * Products' JSON object to create OrderProduct[]
     *
     * @var string
     */
    public $products;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'currency_id', 'created_at', 'updated_at'], 'integer'],
            [['first_name', 'last_name', 'address', 'email', 'phone_number'], 'required'],
            [['total', 'delivery_price'], 'number'],
            [['address'], 'string', 'max' => 1020],
            [['first_name', 'last_name'], 'string', 'max' => 255],
            [['phone_number'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['products'], 'safe'],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::class, 'targetAttribute' => ['currency_id' => 'id']],
        ];
    }

    /**
     * Gets query for [[Currency]].
     *
     * @return Currency
     */
    public function getCurrency()
    {
        return Currency::findOne($this->currency_id);
    }

    /**
     * Saving Order object
     *
     * @return int Returns integer above 0 if order is successful
     */
    public function makeOrder():int
    {
        $cartProducts = json_decode($this->products);
        $quantities = ArrayHelper::map($cartProducts, 'id', 'quantity');
        $products = Product::getProductsByCartItems($cartProducts);
        $currency = $this->getCurrency();

        $orderModel = new Order([
            'user_id' => Yii::$app->user->identity->id,
            'currency_id' => $this->currency_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'total' => Order::getTotalByProducts($products, $quantities, $currency),
            'delivery_price' => Setting::getDeliveryPrice($currency->rate),
        ]);

        $result = $orderModel->save();

        foreach ($cartProducts as $cartProduct) {
            $model = new OrderProduct([
                'order_id' => $orderModel->id,
                'product_id' => $cartProduct->id,
                'quantity' => $cartProduct->quantity,
            ]);
            $result = $result && $model->save();
        }

        return $result ? $orderModel->id : 0;
    }
}