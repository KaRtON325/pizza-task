<?php

namespace app\controllers;

use app\models\SignupForm;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;

class ApiController extends Controller
{
    /**
     * Disables CSRF validation
     *
     * @var bool $enableCsrfValidation
     */
    public $enableCsrfValidation = false;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'login' => ['post'],
                ],
            ],
            'authenticator' => [
                'class' => HttpBearerAuth::class,
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    /**
     * Login action.
     *
     * @return array
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        $model->load(Yii::$app->request->post(), '');
        if ($model->login()) {
            return ['result' => 'success', 'user_id' => Yii::$app->user->getId()];
        } else {
            return ['result' => 'error', 'messages' => $model->getFirstErrors()];
        }
    }

    /**
     * Login action.
     *
     * @return array
     * @throws \Exception
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        $model->load(Yii::$app->request->post(), '');
        if ($model->signup()) {
            return ['result' => 'success', 'user_id' => Yii::$app->user->getId()];
        } else {
            return ['result' => 'error', 'messages' => $model->getFirstErrors()];
        }
    }
}
