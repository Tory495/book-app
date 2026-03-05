<?php

use yii\db\Migration;

class m260305_132542_add_unique_index_subscription_author_phone extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'ux_subscription_author_phone',
            '{{%subscription}}',
            ['author_id', 'phone'],
            unique: true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('ux_subscription_author_phone', '{{%subscription}}');
    }
}
