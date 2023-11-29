<?php

namespace frontend\models;

use common\models\Comment;
use common\models\Post;
use common\models\User;
use yii\data\ActiveDataProvider;

// TODO перенести во frontend
class SerializeCommentsForm
{
    public $limit;
    public $offset;
    public $postId;
    /**
     * @var array|mixed
     */
    public $accessToken;

    public function SerializeAll()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Comment::find(),
            'pagination' => [
                'pageSize' => $this->limit,
                'page' => $this->offset / $this->limit,
            ],
        ]);
        $models = $dataProvider->getModels();
        return $models;
    }

    public function SerializeByUser()
    {
        $user = User::findIdentityByAccessToken($this->accessToken);
        if ($user !== null) {
            $dataProvider = new ActiveDataProvider([
                'query' => Comment::find()->where(['authorId' => $user->id]),
                'pagination' => [
                    'pageSize' => $this->limit,
                    'page' => $this->offset / $this->limit, // Рассчитываем номер страницы на основе offset и limit
                ],
            ]);
            $models = $dataProvider->getModels();
            if(!empty($models)){
                return $dataProvider->getModels();}
            else{
                return ['message' => 'This user does not have any comments'];
            }
        } else {
            return ['error' => 'Invalid access token'];
        }
    }

    public function SerializeByPost()
    {
        $post = Post::findIdentityById($this->postId);
        if ($post !== null) {
            $dataProvider = new ActiveDataProvider([
                'query' => Comment::find()->where(['postId' => $post->id]),
                'pagination' => [
                    'pageSize' => $this->limit,
                    'page' => $this->offset / $this->limit, // Рассчитываем номер страницы на основе offset и limit
                ],
            ]);
            $models = $dataProvider->getModels();
            if(!empty($models)){
                return $dataProvider->getModels();}
            else{
                return ['message' => 'This post does not have any comments'];
            }
        } else {
            return ['error' => 'Invalid post id'];
        }
    }

}