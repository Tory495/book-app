<?php

namespace common\contracts;

use common\models\Author;

interface AuthorServiceInterface
{
    /**
     * @return Author[]
     */
    public function getTopAuthors(?int $year = null): array;

    /**
     * @return Author[]
     */
    public function getAll(): array;

    /**
     * @param int[] $ids
     * @return Author[]
     */
    public function getByIds(array $ids): array;
}