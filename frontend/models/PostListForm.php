<?php

namespace frontend\models;

use common\models\Post;
use common\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;

// TODO перенести во frontend
class SerializePostForm extends Model
{
    public $limit;
    public $offset;
    public $accessToken;

    public function rules()
    {
        return [
            ['limit', 'default' => \Yii::$app->params['defaultLimit']],
        ];
    }

    public function SerializeAll()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Post::find(),
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

            if (!empty($models)) {
                return $data;
            } else {
                return ['message' => 'This user does not have any posts'];
            }
        } else {
            return ['error' => 'Invalid access token'];
        }
    }
}