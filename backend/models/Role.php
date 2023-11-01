<?php

namespace app\models;

use models\User;

/**
 * This is the model class for table "role".
 *
 * @property int $id
 * @property string $roleName
 *
 * @property User[] $users
 */
class Role extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['roleName'], 'required'],
            [['roleName'], 'string', 'max' => 255],
            [['roleName'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'roleName' => 'Role Name',
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['roleId' => 'id']);
    }
}
