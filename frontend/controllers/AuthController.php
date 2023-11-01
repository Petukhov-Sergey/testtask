<?php

namespace frontend\controllers;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\Controller;

class AuthController extends Controller
{


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::class,
        ];
        return $behaviors;
    }
}