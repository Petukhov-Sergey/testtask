<?php

use yii\db\Migration;

/**
 * Class m231016_152035_add_column_role
 */
class m231016_152035_add_column_role extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'roleId', $this->integer()->notNull());
        $this->createIndex(
            'idx-user-roleId',
            'user',
            'roleId'
        );
        $this->addForeignKey(
            'fk-user-roleId',
            'user',
            'roleId',
            'role',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-user-roleId',
            'user'
        );
        $this->dropForeignKey(
            'fk-user-roleId',
            'user'
        );
        $this->dropColumn('{{%user}}', 'roleId');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231016_152035_add_column_role cannot be reverted.\n";

        return false;
    }
    */
}
