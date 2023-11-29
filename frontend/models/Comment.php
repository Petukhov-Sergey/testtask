<?php

namespace common\models;

use Yii;

class Comment extends BaseComment
{

    /**
     * @var mixed|null
     */
    public $accessToken;

    public function createComment(): array
    {
        $user = User::findIdentityByAccessToken($this->accessToken);
        $this->authorId = $user->id;
        if ($user) {
            if ($this->save()) {
                return ['success' => true, 'message' => 'Comment published successfully'];
            } else {
                Yii::$app->response->statusCode = 400; // Устанавливаем статус код 400 для ошибки
                return ['error' => 'Failed to publish comment'];
            }
        } else {
            Yii::$app->response->statusCode = 401; // Устанавливаем статус код 401 для ошибки авторизации
            return ['error' => 'Unauthorized'];
        }
    }

}