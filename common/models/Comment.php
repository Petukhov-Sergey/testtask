<?php

namespace common\models;

use Yii;

class Comment extends BaseComment
{
    /**
     * @var mixed|null
     */
    public $accessToken;

    public function rules()
    {
        return [
            [['accessToken'], 'string'],
            [['postId'], 'integer'],
            [['body'], 'string'],
        ];
    }
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
    public function serializeModelShort()
    {
        $data = [];
        $data['commentId'] = $this->id;
        return $data;
    }

    public function serializeModelFull()
    {
        $data = $this->serializeModelShort();

        $data['text'] = $this->body;
        $data['authorUserId'] = $this->authorId;
        $data['postId'] = $this->authorId;
        return $data;
    }

}