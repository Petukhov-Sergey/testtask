<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;


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
       return $this->$dataProvider->getModels();

    }

}