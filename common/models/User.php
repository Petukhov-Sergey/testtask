<?php

namespace common\models;
//
//use app\models\BaseAccessToken;
//use app\models\Post;
//use app\models\Role;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $authKey
 * @property string $passwordHash
 * @property string|null $passwordResetToken
 * @property string $email
 * @property int $status
 * @property int $createdAt
 * @property int $updatedAt
 * @property string|null $verificationToken
 * @property int $roleId
 *
 * @property Accesstoken $accessToken
 * @property Post[] $posts
 * @property Role $role
 */
class User extends BaseUser
{


    /**
     * Gets query for [[BaseAccessToken]].
     *
     * @param $email
     * @return User|null
     */
    public static function findByEmail($email): ?User
    {
        return static::findOne(['email' => $email]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()
            ->andWhere(['accessToken' => $token])
            ->one();
    }
}
