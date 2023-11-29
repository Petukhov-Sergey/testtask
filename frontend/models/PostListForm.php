<?php

namespace frontend\models;

use common\models\Post;
use common\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;

// TODO перенести во frontend
class PostListForm extends Model
{
    public $limit;
    public $offset;
    public $accessToken;

    public function rules()
    {
        return [
            ['limit', 'default', 'value' => \Yii::$app->params['defaultLimit']],
            ['offset', 'default', 'value' => \Yii::$app->params['defaultOffset']],
            [['accessToken'], 'integer'],
        ];
    }

    public function ListAll()
    {
        $data = [];
       $models = Post::find()
           ->limit($this->limit)
           ->offset($this->offset);
       foreach($models->each() as $model){
           $data[] = $model->serializeModelShort();
       }
       return $data;
    }

    public function ListByUser()
    {
        $data = [];
        $user = User::findIdentityByAccessToken($this->accessToken);
        if ($user !== null) {
            $models = Post::find()
                ->where(['authorId' => $user->id])
                ->limit($this->limit)
                ->offset($this->offset);

            foreach ($models->each() as $model) {
                $data[] = $model->serializeModelShort();
            }
            if ($models->exists()) {
                return $data;
            } else {
                return ['message' => 'This user does not have any posts'];
            }
        } else {
            return ['error' => 'Invalid access token'];
        }
    }
}