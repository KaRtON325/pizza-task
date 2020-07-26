<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property int $id
 * @property string $password_hash
 * @property string $access_token
 * @property string $email
 * @property int $created_at
 * @property int $updated_at
 * @property string $password
 *
 * @property Order[] $orders
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const SCENARIO_CHANGE = 'change';
    const SCENARIO_REGISTER = 'register';
    const SCENARIO_LOGIN = 'login';

    /**
     * @var string To implement IdentityInterface
     */
    public $authKey;

    /**
     * User's entered password
     *
     * @var string
     */
    public $password;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users}}';
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
    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => [],
            self::SCENARIO_CHANGE => ['email', 'password'],
            self::SCENARIO_REGISTER => ['email', 'password'],
            self::SCENARIO_LOGIN => ['email', 'password'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['password_hash', 'email'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['password_hash', 'access_token', 'email'], 'string', 'max' => 255],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'access_token' => Yii::t('app', 'Access Token'),
            'email' => Yii::t('app', 'Email'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @throws \yii\base\Exception
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return FALSE;
        }

        if (in_array($this->scenario, [self::SCENARIO_REGISTER, self::SCENARIO_CHANGE])) {
            $this->generatePasswordHash();
        }

        if (in_array($this->scenario, [self::SCENARIO_REGISTER, self::SCENARIO_LOGIN])) {
            $this->generateAccessToken();
        }

        return TRUE;
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Returns User object by it's email
     *
     * @param $email
     * @return User|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates the password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates and assignes a password hash
     *
     * @throws \yii\base\Exception
     */
    public function generatePasswordHash(): string
    {
        return $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
    }

    /**
     * Generates and assignes an access token
     *
     * @throws \yii\base\Exception
     */
    public function generateAccessToken(): string
    {
        return $this->access_token = Yii::$app->security->generateRandomString();
    }
}
