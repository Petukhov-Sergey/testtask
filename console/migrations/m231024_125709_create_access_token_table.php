<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%access_token}}`.
 */
class m231024_125709_create_access_token_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%accessToken}}', [
            'id' => $this->primaryKey(),
            'userId' => $this->integer()->notNull()->unique(),
            'accessToken'=>$this->string()->notNull(),

        ]);
        $this->addForeignKey(
            'fk-accessToken-userId',
            'accessToken',
            'userId',
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
        $this->dropForeignKey('fk-accessToken-userId', 'accessToken');
        $this->dropTable('{{%access_token}}');
    }
}
