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
    public string $email;

    /**
     * @var string
     */
    public string $password;

    /**
     * @var string
     */
    public string $password_confirm;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password', 'password_confirm'], 'required'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['password_confirm', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('app', 'Passwords don\'t match')],
            ['email', 'email'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     * @throws \Exception
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User([
            'email' => $this->email,
            'password' = $this->password,
            'scenario' => User::SCENARIO_REGISTER
        ]);

        /*Yii::$app->session->setFlash(
            'error',
            Html::errorSummary($user)
        );

        return $isSuccess ? $user : null;*/
    }
}
