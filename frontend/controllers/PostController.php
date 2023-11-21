<?php

namespace frontend\controllers;

use common\models\Post;
use common\models\SerializePostForm;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\Response;

class PostController extends Controller
{
    public function actionCreatePost(): array
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
    public function actionIndex(): Response
    {
        $limit = Yii::$app->request->get('limit', 10); // Получаем параметр limit из GET запроса, по умолчанию 10
        $offset = Yii::$app->request->get('offset', 0); // Получаем параметр offset из GET запроса, по умолчанию 0
        $posts = new SerializePostForm();
        $posts->limit = $limit;
        $posts->offset = $offset;
        return $posts->SerializeAll();

    }
    public function actionUserPosts(): Response
    {
        // Проверяем валидность access token
        $limit = Yii::$app->request->get('limit', 10); // Получаем параметр limit из GET запроса, по умолчанию 10
        $offset = Yii::$app->request->get('offset', 0); // Получаем параметр offset из GET запроса, по умолчанию 0
        $accessToken = Yii::$app->request->get('accessToken');
        $user = User::findIdentityByAccessToken($accessToken);
        if ($user !== null) {
            $dataProvider = new ActiveDataProvider([
                'query' => Post::find()->where(['user_id' => $user->id]),
                'pagination' => [
                    'pageSize' => $limit,
                    'page' => $offset / $limit, // Рассчитываем номер страницы на основе offset и limit
                ],
            ]);
            return $this->asJson($dataProvider->getModels());
        } else {
            return $this->asJson(['error' => 'Invalid access token']);
        }
    }

}