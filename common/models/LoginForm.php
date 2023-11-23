<?php

namespace common\models;

use Yii;
use yii\base\Model;


/**
 * Login form
 */
class LoginForm extends Model
{
    public $email;
    public $password;



    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function login($isAdmin)
    {
        if ($this->validate()) {
            $user = \common\models\User::findByEmail($this->email);

            if ($user !== null && Yii::$app->security->validatePassword($this->password, $user->passwordHash)) {
                // Генерация и обновление accessToken
                if($isAdmin && ($user->roleId!=3)){
                    $this->addError('role', 'You do not have permission to login');
                    return false;
                }
                $accessToken = Yii::$app->security->generateRandomString();
                $accessTokenModel = Accesstoken::findOne(['userId' => $user->id]);
                if ($accessTokenModel === null) {
                    $accessTokenModel = new Accesstoken();
                    $accessTokenModel->userId = $user->id;
                }
                $accessTokenModel->accessToken = $accessToken;
                if ($accessTokenModel->save()) {
                    return $accessTokenModel->accessToken;
                } else {
                    return false;
                }
            } else {
                $this->addError('password', 'Incorrect email or password');
                return false;
            }
        }
        return false;
    }
}
