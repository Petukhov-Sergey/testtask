<?php

namespace frontend\models;
use common\models\BaseUser;
use yii\web\IdentityInterface;

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
class User extends BaseUser implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;


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

    public static function findIdentityByAccessToken($token, $type = null): ?User
    {
        $accessToken = AccessToken::findOne(['accessToken' => $token]);
        if ($accessToken) {
            return static::findOne(['id' => $accessToken->userId]);
        }
        return null;
    }


    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->passwordHash);
    }
}
