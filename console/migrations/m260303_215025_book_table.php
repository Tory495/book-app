<?php

use yii\db\Migration;

class m260303_215025_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'year' => $this->integer()->notNull(),
            'description' => $this->text(),
            'isbn' => $this->string(13)->notNull()->unique(),
            'image' => $this->string(),
        ]);

        $this->createTable('{{%book_author}}', [
            'book_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('pk_ba', '{{%book_author}}', ['book_id', 'author_id']);
        $this->addForeignKey('fk_ba_book', '{{%book_author}}', 'book_id', '{{%book}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_ba_author', '{{%book_author}}', 'author_id', '{{%author}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropForeignKey('fk_ba_book', '{{%book_author}}');
        $this->dropForeignKey('fk_ba_author', '{{%book_author}}');

        $this->dropTable('{{%book_author}}');
        $this->dropTable('{{%book}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260303_215025_book_table cannot be reverted.\n";

        return false;
    }
    */
}
