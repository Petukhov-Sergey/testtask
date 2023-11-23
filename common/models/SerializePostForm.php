<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use function PHPUnit\Framework\assertJson;


class SerializePostForm extends Model
{
    public $limit;
    public $offset;
    public $accessToken;
    public function SerializeAll(){
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

    public function SerializeByUser(){
        $user = User::findIdentityByAccessToken($this->accessToken);
        if ($user !== null) {
            $dataProvider = new ActiveDataProvider([
                'query' => Post::find()->where(['authorId' => $user->id]),
                'pagination' => [
                    'pageSize' => $this->limit,
                    'page' => $this->offset / $this->limit, // Рассчитываем номер страницы на основе offset и limit
                ],
            ]);
            $models = $dataProvider->getModels();
            if(!empty($models)){
                return $dataProvider->getModels();}
            else{
                return ['message' => 'This user does not have any posts'];
            }
        } else {
            return ['error' => 'Invalid access token'];
        }
    }

}