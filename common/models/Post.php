<?php

namespace common\models;

use Yii;
use yii\validators\RequiredValidator;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $authorId
 * @property string|null $title
 * @property string|null $body
 *
 * @property User $author
 */
class Post extends BasePost
{
    /**
     * @var mixed|null
     */
    public $accessToken;

    public static function findIdentityById($postId)
    {
        return Post::findOne(['id' => $postId]);
    }

    public function rules()
    {
        return [
            [['accessToken', 'body', 'title'], RequiredValidator::class],
        ];
    }

    public function createPost(): array
    {
        $user = User::findIdentityByAccessToken($this->accessToken);
        $this->authorId = $user->id;
        if ($user) {
            if ($this->save()) {
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

    public function SerializePost()
    {
        $user = User::findIdentityByAccessToken($this->accessToken);
        $this->authorId = $user->id;
        if ($user) {
            if ($user->getPosts()) {
                return $user->getPosts();
            } else {
                Yii::$app->response->statusCode = 400; // Устанавливаем статус код 400 для ошибки
                return ['error' => 'This user has no posts'];
            }
        } else {
            Yii::$app->response->statusCode = 401; // Устанавливаем статус код 401 для ошибки авторизации
            return ['error' => 'Unauthorized'];
        }
    }


}
