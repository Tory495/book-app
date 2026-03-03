<?php

use yii\db\Migration;

class m260303_215219_subscription_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%subscription}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'phone' => $this->string(20)->notNull(),
        ]);

        $this->addForeignKey('fk_sub_author', '{{%subscription}}', 'author_id', '{{%author}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropForeignKey('fk_sub_author', '{{%subscription}}');

        $this->dropTable('{{%subscription}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260303_215219_subscription_table cannot be reverted.\n";

        return false;
    }
    */
}
