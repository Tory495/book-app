<?php

namespace common\repo\mysql\author;

use common\contracts\AuthorRepoInterface;
use common\models\Author;

final class AuthorRepo implements AuthorRepoInterface
{
    public function getTopAuthors(?int $year = null): array
    {
        $query = Author::find()
            ->select([
                '{{%author}}.*',
                'books_count' => new \yii\db\Expression('COUNT({{%book_author}}.book_id)')
            ])
            ->joinWith('books', false, 'INNER JOIN')
            ->groupBy('{{%author}}.id')
            ->orderBy(['books_count' => SORT_DESC])
            ->limit(10);

        if ($year) {
            $query->andWhere(['{{%book}}.year' => $year]);
        }

        return $query->all();
    }

    /**
     * @return Author[]
     */
    public function getAll(): array
    {
        return Author::find()->orderBy(['full_name' => SORT_ASC])->all();
    }

    /**
     * @param int[] $ids
     * @return Author[]
     */
    public function getByIds(array $ids): array
    {
        return Author::find()->where(['id' => $ids])->all();
    }
}
