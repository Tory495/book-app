<?php

use yii\db\Migration;

class m260304_224945_add_index_to_books_year_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createIndex('idx_books_year', '{{%book}}', 'year');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropIndex('idx_books_year', '{{%book}}');
    }
}
