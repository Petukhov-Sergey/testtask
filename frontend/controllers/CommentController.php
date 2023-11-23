<?php

namespace frontend\controllers;

use common\models\Comment;
use common\models\Post;
use common\models\SerializeCommentsForm;
use common\models\SerializePostForm;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class CommentController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'create' => ['post'],
                    'index' => ['get'],
                    'getByPost' => ['get'],
                ],
            ],

        ];
    }
    public static function actionCreate(){
        $accessToken = Yii::$app->request->post('accessToken');
        $text = Yii::$app->request->post('text');
        $postId = Yii::$app->request->post('postId');
        $comment = new Comment();
        $comment->accessToken = $accessToken;
        $comment->body = $text;
        $comment->postId = $postId;
        $message = $comment->createComment();
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $message;

    }
    public static function actionGetByUser(){
        $limit = Yii::$app->request->get('limit', 10); // Получаем параметр limit из GET запроса, по умолчанию 10
        $offset = Yii::$app->request->get('offset', 0); // Получаем параметр offset из GET запроса, по умолчанию 0
        $accessToken = Yii::$app->request->get('accessToken');
        $posts = new SerializeCommentsForm();
        $posts->limit = $limit;
        $posts->offset = $offset;
        $posts->accessToken = $accessToken;
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $posts->SerializeByUser();
    }
    public static function actionGetByPost(){
        $limit = Yii::$app->request->get('limit', 10); // Получаем параметр limit из GET запроса, по умолчанию 10
        $offset = Yii::$app->request->get('offset', 0); // Получаем параметр offset из GET запроса, по умолчанию 0
        $postId = Yii::$app->request->get('postId');
        $posts = new SerializeCommentsForm();
        $posts->limit = $limit;
        $posts->offset = $offset;
        $posts->postId = $postId;
        //return(json_encode());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $posts->SerializeByPost();
    }
    public static function actionIndex(){
        $limit = Yii::$app->request->get('limit', 10); // Получаем параметр limit из GET запроса, по умолчанию 10
        $offset = Yii::$app->request->get('offset', 0); // Получаем параметр offset из GET запроса, по умолчанию 0
        $comments = new SerializeCommentsForm();
        $comments->limit = $limit;
        $comments->offset = $offset;
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $comments->SerializeAll();

    }
}