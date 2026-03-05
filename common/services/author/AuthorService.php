<?php

namespace common\services\author;

use common\models\Author;
use common\contracts\AuthorRepoInterface;

final class AuthorService
{
    public function __construct(
        private AuthorRepoInterface $authorRepo,
    ) {}

    /**
     * @return Author[]
     */
    public function getTopAuthors(?int $year = null): array
    {
        return $this->authorRepo->getTopAuthors($year);
    }
}
