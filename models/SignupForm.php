<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property string $email
 * @property string $password
 * @property string $password_confirm
 *
 */
class SignupForm extends Model
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
     * @var string
     */
    public $password_confirm;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'password', 'password_confirm'], 'required'],

            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' =>  Yii::t('app', 'This email address has already been taken.')],

            ['password', 'string', 'min' => 6],

            ['password_confirm', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('app', 'Passwords don\'t match')],

            ['email', 'email'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|SignupForm
     * @throws \Exception
     */
    public function signup():Model
    {
        if (!$this->validate()) {
            return $this;
        }

        $model = new User([
            'email' => $this->email,
            'password' => $this->password,
            'scenario' => User::SCENARIO_REGISTER
        ]);
        $model->save();

        return $model;
    }
}
