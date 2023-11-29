<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comment}}`.
 */
class m231123_104855_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // TODO authorUserId
        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'postId' => $this->integer()->notNull(),
            'authorId' => $this->integer()->notNull(),
            'body' => $this->text(),
        ]);
        $this->createIndex(
            'idx-comment-authorId',
            'comment',
            'authorId'
        );
        $this->addForeignKey(
            'fk-comment-authorId',
            'comment',
            'authorId',
            'user',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            'idx-comment-postId',
            'comment',
            'postId'
        );
        $this->addForeignKey(
            'fk-comment-postId',
            'comment',
            'postId',
            'post',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-comment-postId', 'comment');
        $this->dropIndex('idx-comment-postId', 'comment');
        $this->dropForeignKey('fk-comment-authorId', 'comment');
        $this->dropIndex('idx-comment-authorId', 'comment');
        $this->dropTable('{{%comment}}');
    }
}
