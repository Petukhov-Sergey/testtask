<?php

use common\models\Accesstoken;
use common\models\User;
use yii\db\Migration;

/**
* Class m231030_110956_createUsers
*/
class m231030_110956_createUsers extends Migration
{
/**
* {@inheritdoc}
*/

// TODO отформатировать
public function safeUp()
{
    $this->insert('user', [
        'username' => 'user1',
        'authKey' => 'auth_key_1',
        'passwordHash' => Yii::$app->security->generatePasswordHash('123'),
        'email' => 'user1@example.com',
        'status' => 10,
        'createdAt' => time(),
        'updatedAt' => time(),
        'roleId' => 4,
    ]);
    $user = User::findOne(['username' => 'user1']);

    $accessToken = new Accesstoken();
    $accessToken->userId = $user->id;
    $accessToken->accessToken = Yii::$app->security->generateRandomString();
    $accessToken->save();

    $this->insert('user', [
    'username' => 'admin1',
    'authKey' => 'auth_key_2',
    'passwordHash' => Yii::$app->security->generatePasswordHash('123'),
    'email' => 'user2@example.com',
    'status' => 10,
    'createdAt' => time(),
    'updatedAt' => time(),
    'roleId' => 3,
    ]);
    $user = User::findOne(['username' => 'admin1']);

    $accessToken = new Accesstoken();
    $accessToken->userId = $user->id;
    $accessToken->accessToken = Yii::$app->security->generateRandomString();
    $accessToken->save();
}

/**
* {@inheritdoc}
*/
public function safeDown()
{
$this->delete('user', ['username' => 'user1']);
$this->delete('user', ['username' => 'admin1']);
}
}