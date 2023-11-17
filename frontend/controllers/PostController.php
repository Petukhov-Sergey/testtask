<?php

namespace frontend\controllers;

use common\models\Post;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class PostController extends Controller
{
    public function actionCreatePost()
    {
        $accessToken = Yii::$app->request->post('accessToken');
        $text = Yii::$app->request->post('text');
        $title = Yii::$app->request->post('title');

        $user = User::findIdentityByAccessToken($accessToken);

        if ($user) {
            $post = new Post();
            $post->authorId = $user->id;
            $post->body = $text;
            $post->title = $title;

            if ($post->save()) {
                return ['success' => true, 'message' => 'Post published successfully'];
            } else {
                Yii::$app->response->statusCode = 400; // Устанавливаем статус код 400 для ошибки
                return ['error' => 'Failed to publish post'];
            }
        } else {
            Yii::$app->response->statusCode = 401; // Устанавливаем статус код 401 для ошибки авторизации
            return ['error' => 'Unauthorized'];
        }
    }
    public function actionIndex()
    {
        $limit = Yii::$app->request->get('limit', 10); // Получаем параметр limit из GET запроса, по умолчанию 10
        $offset = Yii::$app->request->get('offset', 0); // Получаем параметр offset из GET запроса, по умолчанию 0

        $dataProvider = new ActiveDataProvider([
            'query' => Post::find(),
            'pagination' => [
                'pageSize' => $limit,
                'page' => $offset / $limit,
            ],
        ]);
        return $this->asJson($dataProvider->getModels());
    }
    public function actionUserPosts()
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