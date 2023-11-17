<?php

namespace frontend\controllers;
use common\models\LoginForm;
use common\models\User;
use Yii;
use yii\web\Controller;
use yii\web\Response;
class UserController extends Controller
{
    public function actionLogin()
    {
        $params = Yii::$app->request->getBodyParams();
        $email = $params['email'];
        $password = $params['password'];


        $model = new LoginForm();
        $model->email = $email;
        $model->password = $password;

        $accessToken = $model->login(false); // Вызываем метод login в модели LoginForm

        if ($accessToken !== false) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['accessToken' => $accessToken];
        }else {
            Yii::$app->response->statusCode = 401; // Устанавливаем статус код 401 для ошибки аутентификации
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['error' => 'Invalid email or password',];
        }
    }
    public function actionRegister()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Возвращаем accessToken или ошибку
            return ['accessToken' => $model->generateAccessToken()];
        } else {
            Yii::$app->response->statusCode = 400; // Устанавливаем статус код 400 для ошибки
            return ['error' => 'Failed to register user'];
        }
    }

}

