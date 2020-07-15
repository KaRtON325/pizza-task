<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%orders}}".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $address
 * @property string $email
 * @property string $phone_number
 * @property float $total
 * @property float $delivery_price
 *
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
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['first_name', 'last_name', 'address', 'email', 'phone_number', 'total', 'delivery_price'], 'required'],
            [['total', 'delivery_price'], 'number'],
            [['first_name', 'last_name', 'address', 'email', 'phone_number'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'address' => Yii::t('app', 'Address'),
            'email' => Yii::t('app', 'Email'),
            'phone_number' => Yii::t('app', 'Phone Number'),
            'total' => Yii::t('app', 'Total'),
            'delivery_price' => Yii::t('app', 'Delivery Price'),
        ];
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
}
