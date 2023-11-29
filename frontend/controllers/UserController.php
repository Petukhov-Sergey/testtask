<?php

namespace frontend\controllers;
use frontend\models\LoginFormApi;
use frontend\models\RegisterForm;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'login' => ['post'],
                    'register' => ['post'],
                ],
            ],

        ];
    }
    public function actionLogin(): array
    {
        $model = new LoginFormApi();
        $model->load(Yii::$app->request->post(), '');
        $model->validate();
        $accessToken = $model->login(); // Вызываем метод login в модели LoginFormApi
        if ($accessToken !== false) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['accessToken' => $accessToken];
        }else {
            Yii::$app->response->statusCode = 401; // Устанавливаем статус код 401 для ошибки аутентификации
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['error' => 'Invalid email or password',];
        }
    }
    public function actionRegister(): array
    {
        $model = new RegisterForm();
        $model->load(Yii::$app->request->post(), '');
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $model->register();
    }

}

