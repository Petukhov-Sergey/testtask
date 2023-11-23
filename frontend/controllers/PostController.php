<?php

namespace frontend\controllers;

use common\models\Post;
use common\models\SerializePostForm;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class PostController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'createPost' => ['post'],
                    'index' => ['get'],
                    'userPosts' => ['get'],
                ],
            ],

        ];
    }
    public function actionCreatePost()
    {
        $accessToken = Yii::$app->request->post('accessToken');
        $text = Yii::$app->request->post('text');
        $title = Yii::$app->request->post('title');

        $post = new Post();
        $post->accessToken = $accessToken;
        $post->body = $text;
        $post->title = $title;
        $message = $post->createPost();
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $message;
    }
    public function actionIndex()
    {
        $limit = Yii::$app->request->get('limit', Yii::$app->params['defaultLimit']); // Получаем параметр limit из GET запроса, по умолчанию 10
        $offset = Yii::$app->request->get('offset', Yii::$app->params['defaultOffset']); // Получаем параметр offset из GET запроса, по умолчанию 0
        $posts = new SerializePostForm();
        $posts->limit = $limit;
        $posts->offset = $offset;
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $posts->SerializeAll();
    }
    public function actionUserPosts()
    {
        // Проверяем валидность access token
        $limit = Yii::$app->request->get('limit', Yii::$app->params["defaultLimit"]); // Получаем параметр limit из GET запроса, по умолчанию 10
        $offset = Yii::$app->request->get('offset', Yii::$app->params["defaultOffset"]); // Получаем параметр offset из GET запроса, по умолчанию 0
        $accessToken = Yii::$app->request->get('accessToken');
        $posts = new SerializePostForm();
        $posts->limit = $limit;
        $posts->offset = $offset;
        $posts->accessToken = $accessToken;
        //return(json_encode());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $posts->SerializeByUser();
    }

}