<?php

use yii\db\Migration;

/**
 * Class m231030_110915_createRoles
 */
class m231030_110915_createRoles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('role', [
            'roleName' => 'admin',
        ]);

        $this->insert('role', [
            'roleName' => 'user',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('role', ['roleName' => 'user']);
        $this->delete('role', ['roleName' => 'admin']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231030_110915_createRoles cannot be reverted.\n";

        return false;
    }
    */
}
