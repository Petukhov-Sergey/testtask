<?php

namespace common\models;

use Yii;
use yii\base\Model;


/**
 * Register form
 */

class RegisterForm extends Model
{
    public $email;
    public $password;
    public $username;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password', 'username'], 'required'],
        ];
    }
    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function register()
    {
        $date = strtotime(date('Y-m-d h:i:s'));
        if ($this->validate()) {
            $user = new User([
                'email' => $this->email,
                'username' => $this->username,
                'passwordHash' => password_hash($this->password, PASSWORD_DEFAULT),
                'authKey' => Yii::$app->security->generateRandomString(),
                'status' => 10,
                'createdAt'=> $date,
                'updatedAt' => $date,
                'roleId' => 4,
            ]);
            if ($user->save()) {
                return self::generateAccessToken($user->id);
            } else {
                //print_r($user->errors);
                // Если не удалось сохранить пользователя, возвращаем ошибку
                Yii::$app->response->statusCode = 400;
                return ['error' => 'Failed to register user'];
            }

        }
        else
            return ['error'=>'Failed to register user'];
    }
    public static function generateAccessToken($id)
    {
        $accessToken = Yii::$app->security->generateRandomString();
        $accessTokenModel = new Accesstoken();
        $accessTokenModel->userId = $id;
        $accessTokenModel->accessToken = $accessToken;
        if ($accessTokenModel->save()) {
            return ['accessToken' => $accessTokenModel->accessToken];
        } else {
            return ['error' => 'Failed to register user'];
        }

    }
}
