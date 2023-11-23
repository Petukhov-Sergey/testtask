<?php

namespace common\models;

use common\models\Post;
use common\models\User;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property int $postId
 * @property int $authorId
 * @property string|null $body
 *
 * @property User $author
 * @property Post $post
 */
class BaseComment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['postId', 'authorId'], 'required'],
            [['postId', 'authorId'], 'integer'],
            [['body'], 'string'],
            [['authorId'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['authorId' => 'id']],
            [['postId'], 'exist', 'skipOnError' => true, 'targetClass' => Post::class, 'targetAttribute' => ['postId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'postId' => 'Post ID',
            'authorId' => 'Author ID',
            'body' => 'Body',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'authorId']);
    }

    /**
     * Gets query for [[Post]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::class, ['id' => 'postId']);
    }
}
