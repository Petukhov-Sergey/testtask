<?php

namespace common\models;

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
 * @property BaseAccessToken $accessToken
 * @property BasePost[] $posts
 * @property BaseRole $role
 */
class BaseUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'authKey', 'passwordHash', 'email', 'createdAt', 'updatedAt', 'roleId'], 'required'],
            [['status', 'createdAt', 'updatedAt', 'roleId'], 'integer'],
            [['username', 'passwordHash', 'passwordResetToken', 'email', 'verificationToken'], 'string', 'max' => 255],
            [['authKey'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['passwordResetToken'], 'unique'],
            [['roleId'], 'exist', 'skipOnError' => true, 'targetClass' => BaseRole::class, 'targetAttribute' => ['roleId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'authKey' => 'Auth Key',
            'passwordHash' => 'Password Hash',
            'passwordResetToken' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'verificationToken' => 'Verification Token',
            'roleId' => 'BaseRole ID',
        ];
    }

    /**
     * Gets query for [[BaseAccessToken]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAccessToken()
    {
        return $this->hasOne(BaseAccessToken::class, ['userId' => 'id']);
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(BasePost::class, ['authorId' => 'id']);
    }

    /**
     * Gets query for [[BaseRole]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(BaseRole::class, ['id' => 'roleId']);
    }
}
