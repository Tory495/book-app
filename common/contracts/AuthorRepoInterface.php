<?php

namespace common\contracts;

use common\models\Author;

interface AuthorRepoInterface
{
    /**
     * @return Author[]
     */
    public function getTopAuthors(?int $year = null): array;

    /**
     * @return Author[]
     */
    public function getAll(): array;
}
