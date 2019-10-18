<?php

use yii\db\Migration;

/**
 * Class m191017_132025_apple_table
 */
class m191017_132025_apple_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%apple}}', [
            'id' => $this->primaryKey(),
            'color' => $this->string(24)->notNull(),
            'status' => $this->integer(),
            'size' => $this->double(),
            'fallen_at' => $this->integer(8),
            'created_at' => $this->integer(8),
            'deleted_at' => $this->integer(8),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%apple}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191017_132025_apple_table cannot be reverted.\n";

        return false;
    }
    */
}
