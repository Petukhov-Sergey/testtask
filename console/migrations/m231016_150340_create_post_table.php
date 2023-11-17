<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post}}`.
 */
class m231016_150340_create_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'authorId' => $this->integer()->notNull(),
            'title' => $this->string(),
            'body' => $this->text(),
        ]);
        $this->createIndex(
            'idx-post-authorId',
            'post',
            'authorId'
        );
        $this->addForeignKey(
            'fk-post-authorId',
            'post',
            'authorId',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-post-authorId',
            'post'
        );
        $this->dropIndex(
            'idx-post-authorId',
            'post'
        );


        $this->dropTable('{{%post}}');
    }
}
