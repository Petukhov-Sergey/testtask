<?php

use yii\db\Migration;

/**
 * Class m231016_145501_create_table_role
 */
class m231016_145501_create_table_role extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // TODO не обязательно передавать опции каждый раз
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%role}}', [
            'id' => $this->primaryKey(),
            'roleName' => $this->string()->notNull()->unique(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%role}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231016_145501_create_table_roles cannot be reverted.\n";

        return false;
    }
    */
}
