<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class AuthController extends Controller
{
    public function actionLogin()
    {
        $params = Yii::$app->request->getBodyParams();
        $email = $params['email'];
        $password = $params['password'];


        $model = new LoginForm();
        $model->email = $email;
        $model->password = $password;

        $accessToken = $model->login(true); // Вызываем метод login в модели LoginForm

        if ($accessToken !== false) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['accessToken' => $accessToken];
        }else {
            Yii::$app->response->statusCode = 401; // Устанавливаем статус код 401 для ошибки аутентификации
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['error' => 'Invalid email or password',];
        }
    }
}