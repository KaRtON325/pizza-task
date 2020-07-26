<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property string $email
 * @property string $password
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @var User
     */
    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // Email and password are both required
            [['email', 'password'], 'required'],
            // Password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['password', 'string'],
            // Email is validated by yii\validators\EmailValidator
            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     */
    public function validatePassword(string $attribute): bool
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect email or password.');
                return FALSE;
            }

            return TRUE;
        }

        return FALSE;
    }

    /**
     * Logs in a user using the provided username and password.
     * @throws \Throwable
     */
    public function login(): Model
    {
        if (!$this->validate()) {
            return $this;
        }

        $user = $this->getUser();
        if ($this->validatePassword('email')) {
            $user->scenario = User::SCENARIO_LOGIN;
            $user->save();
            Yii::$app->user->login($user);
        }

        return $user;
    }

    /**
     * Finds user by [[email]]
     */
    public function getUser(): User
    {
        if ($this->_user === false) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }
}
