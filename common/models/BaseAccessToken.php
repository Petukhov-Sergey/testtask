<?php

namespace common\models;

/**
 * This is the model class for table "accessToken".
 *
 * @property int $id
 * @property int $userId
 * @property string $accessToken
 *
 * @property BaseUser $user
 */
class BaseAccessToken extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'accessToken';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'accessToken'], 'required'],
            [['userId'], 'integer'],
            [['accessToken'], 'string', 'max' => 255],
            [['userId'], 'unique'],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => BaseUser::class, 'targetAttribute' => ['userId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => 'BaseUser ID',
            'accessToken' => 'Access Token',
        ];
    }

    /**
     * Gets query for [[BaseUser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(BaseUser::class, ['id' => 'userId']);
    }
}
