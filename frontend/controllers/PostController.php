<?php

namespace frontend\controllers;

use common\models\Post;
use frontend\models\PostListForm;
use Yii;
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
        $post = new Post();
        $post->load(Yii::$app->request->post(), '');
        $post->validate();
        $message = $post->createPost();
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $message;
    }
    public function actionIndex()
    {
        $posts = new PostListForm();
        $posts->load(Yii::$app->request->get(), '');
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $posts->ListAll();
    }
    public function actionUserPosts()
    {
        $posts = new PostListForm();
        $posts->load(Yii::$app->request->get(), '');
        $posts->validate();
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $posts->ListByUser();
    }

}