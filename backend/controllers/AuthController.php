<?php

namespace backend\controllers;
use yii\rest\Controller;
use yii\filters\auth\HttpBasicAuth;
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