<?php

use yii\db\Migration;

class m260304_225634_add_index_to_book_author_author_id_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createIndex('idx_ba_author_id', '{{%book_author}}', 'author_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropIndex('idx_ba_author_id', '{{%book_author}}');
    }
}
