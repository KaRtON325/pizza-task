<?php

namespace app\controllers;

use app\models\Banner;
use app\models\Currency;
use app\models\Order;
use app\models\OrderForm;
use app\models\Product;
use app\models\SignupForm;
use app\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\helpers\Html;
use yii\rest\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;

class ApiController extends Controller
{
    /**
     * Enables of disables CSRF validation
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
                    'signup' => ['post'],
                    'order' => ['post'],
                ],
            ],
            'authenticator' => [
                'class' => HttpBearerAuth::class,
                'optional' => ['public-*'], // Methods with "public-" prefix are accessible for unauthorized users
            ],
        ];
    }

    /**
     * {@inheritdoc}
     * @throws \yii\web\BadRequestHttpException
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
     * @throws \Throwable
     */
    public function actionPublicLogin()
    {
        $model = new LoginForm();
        $model->load(Yii::$app->request->post(), '');
        $resultModel = $model->login();

        // There either can be User model or LoginForm model to show errors
        if (!$resultModel->hasErrors()) {
            return ['status' => TRUE, 'access_token' => Yii::$app->user->identity->access_token];
        } else {
            return ['status' => FALSE, 'messages' => Html::errorSummary($resultModel)];
        }
    }

    /**
     * Logout action. Cleares user access_token
     *
     * @return array
     * @throws \Throwable
     */
    public function actionLogout()
    {
        /**
         * @var $model User
         */
        $model = Yii::$app->user->identity;

        if ($model) {
            $model->access_token = NULL;

            if ($model->save()) {
                return ['status' => TRUE];
            } else {
                return ['status' => FALSE, 'errors' => Html::errorSummary($model)];
            }
        }

        return ['status' => FALSE, 'errors' => 'User has already logged out.'];
    }

    /**
     * Returns user id. If id is null then user is not logged in
     *
     * @return int|string
     */
    public function actionPublicCheckUser()
    {
        return Yii::$app->user->identity !== NULL;
    }

    /**
     * Signup action.
     *
     * @return array
     * @throws \Exception
     */
    public function actionPublicSignup()
    {
        $model = new SignupForm();
        $model->load(Yii::$app->request->post(), '');

        // There either can be User model or SignupForm model to show errors
        $resultModel = $model->signup();
        if (!$resultModel->hasErrors()) {
            return ['status' => TRUE, 'access_token' => $resultModel->access_token];
        } else {
            return ['status' => FALSE, 'errors' => Html::errorSummary($resultModel)];
        }
    }

    /**
     * Returns yii\data\ActiveDataProvider object formed by query
     *
     * @return ActiveDataProvider
     */
    public function actionPublicGetBanners(): ActiveDataProvider {
        return new ActiveDataProvider([
            'query' => Banner::find(),
            'pagination' => [
                'pageSize' => 0,
            ],
        ]);
    }

    /**
     * Returns array containing product and delivery prices
     *
     * @param string $cartProducts
     * @return array
     */
    public function actionPublicGetPrices(string $cartProducts): array {
        return Order::getPrices(json_decode($cartProducts));
    }

    /**
     * Returns yii\data\ActiveDataProvider object formed by query
     *
     * @return ActiveDataProvider
     */
    public function actionPublicGetProducts(): ActiveDataProvider {
        return new ActiveDataProvider([
            'query' => Product::find()->joinWith(['productProperties', 'productProperties.property']),
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
    public function actionPublicGetCurrencies(): ActiveDataProvider {
        return new ActiveDataProvider([
            'query' => Currency::find(),
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
    public function actionPublicGetHistory(): ActiveDataProvider {
        return new ActiveDataProvider([
            'query' => Order::find()->joinWith(['orderProducts', 'orderProducts.product', 'currency'])->where(['user_id' => Yii::$app->user->identity->id]),
            'pagination' => [
                'pageSize' => 0,
            ],
        ]);
    }

    /**
     * Creates a new OrderForm model.
     *
     * @return array
     */
    public function actionPublicOrder(): array {
        $model = new OrderForm();

        if ($model->load(Yii::$app->request->post(), '') && $orderId = $model->makeOrder()) {
            return ['status' => TRUE, 'order_id' => $orderId];
        }

        return ['status' => FALSE, 'errors' => $model->getFirstErrors()];
    }
}
