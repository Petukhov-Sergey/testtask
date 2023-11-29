<?php

namespace frontend\models;

use common\models\Comment;
use common\models\Post;
use common\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class CommentListForm extends Model
{
    public $limit;
    public $offset;
    public $postId;
    /**
     * @var array|mixed
     */
    public $accessToken;

    public function rules()
    {
        return [
            [['postId', 'accessToken'], 'integer'],
            ['limit', 'default', 'value' => \Yii::$app->params['defaultLimit']],
            ['offset', 'default', 'value' => \Yii::$app->params['defaultOffset']],
        ];
    }

    public function ListAllComments()
    {
        $data = [];
        $models =  Comment::find()
            ->limit($this->limit)
            ->offset($this->offset);
        foreach($models->each() as $model){
            $data[] = $model->serializeModelShort();
        }
        return $data;
    }

    public function ListUserComments()
    {
        $user = User::findIdentityByAccessToken($this->accessToken);
        if ($user !== null) {
            $data = [];
            $models =  Comment::find()
                        ->where(['authorId' => $user->id])
                        ->limit($this->limit)
                        ->offset($this->offset);
            if($models->exists()){
                foreach($models->each() as $model){
                    $data[] = $model->serializeModelShort();
                }
                return $data;
            }
            else {
                return ['message' => 'This user does not have any comments'];
            }
        } else {
            return ['error' => 'Invalid access token'];
        }
    }

    public function ListPostComments()
    {
        $post = Post::findIdentityById($this->postId);
        if ($post !== null) {
            $data = [];
            $models =  Comment::find()
                ->where(['postId' => $post->id])
                ->limit($this->limit)
                ->offset($this->offset);
            if($models->exists()){
                foreach($models->each() as $model){
                    $data[] = $model->serializeModelShort();
                }
                return $data;
            }
            else{
                return ['message' => 'This post does not have any comments'];
            }
        } else {
            return ['error' => 'Invalid post id'];
        }
    }

}