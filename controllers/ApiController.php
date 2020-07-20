<?php

namespace app\controllers;

use app\models\Banner;
use app\models\Product;
use app\models\SignupForm;
use Yii;
use yii\data\ActiveDataProvider;
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
    public $enableCsrfValidation = true;

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
                'only' => ['getBanners']
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

    /**
     * Returns yii\data\ActiveDataProvider object formed by query
     *
     * @return ActiveDataProvider
     */
    public function actionGetBanners() {
        return new ActiveDataProvider([
            'query' => Banner::find(),
            'pagination' => [
                'pageSize' => 0,
            ],
        ]);
    }

    /**
     * Returns yii\data\ActiveDataProvider object formed by query
     *
     * @return ActiveDataProvider
     */
    public function actionGetProducts() {
        return new ActiveDataProvider([
            'query' => Product::find()->joinWith(['productProperties', 'productProperties.property']),
            'pagination' => [
                'pageSize' => 0,
            ],
        ]);
    }
}
