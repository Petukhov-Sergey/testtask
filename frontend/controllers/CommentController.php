<?php

namespace frontend\controllers;

use common\models\Comment;
use frontend\models\CommentListForm;
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

        $comment = new Comment();
        $comment->load(Yii::$app->request->post(), '');
        $comment->validate();
        $message = $comment->createComment();
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $message;

    }
    public static function actionGetByUser(){
        $comments = new CommentListForm();
        $comments->load(Yii::$app->request->get(), '');
        $comments->validate();
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $comments->ListUserComments();
    }
    public static function actionGetByPost(){

        $comments = new CommentListForm();
        $comments->load(Yii::$app->request->get(), '');
        $comments->validate();
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $comments->ListPostComments();
    }
    public static function actionIndex(){
        $comments = new CommentListForm();
        $comments->load(Yii::$app->request->get(), '');
        $comments->validate();
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $comments->ListAllComments();
    }
}